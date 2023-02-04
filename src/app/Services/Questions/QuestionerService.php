<?php

namespace App\Services\Questions;

use App\Models\BaseModel;
use App\Models\Basic\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Models\Questions\Questioner;
use App\Http\Resources\Questions\QuestionerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Exceptions\Questions\QuestionerWithQuestionsCantBeDeletedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionerService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            Questioner::COLUMN_TITLE => $request->post('title'),
            Questioner::COLUMN_SLUG => $request->post('slug'),
            Questioner::COLUMN_PRICE => $request->post('price'),
        ];
    }

    /**
     * @param int $page
     * @param int|null $userId
     * @return AnonymousResourceCollection
     */
    public function getAll(int $page, ?int $userId): AnonymousResourceCollection
    {
        $items = Questioner::with([
            'questionGroups',
            'userQuestionGroups' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])->forPage($page, $this->perPage)->get();

        return QuestionerResource::collection($items);
    }

    /**
     * @param Questioner $questioner
     * @param int|null $userId
     * @return Questioner
     */
    public function getItem(Questioner $questioner, ?int $userId): QUestioner
    {
        return Questioner::where('id', $questioner->getId())->with([
            'questionGroups',
            'userQuestionGroups' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])->first();
    }

    /**
     * @return int
     */
    public function countTotal(): int
    {
        return Questioner::all()->count();
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        $item = new Questioner();
        $item->setTitle($data[Questioner::COLUMN_TITLE])
            ->setSlug($data[Questioner::COLUMN_SLUG])
            ->setPrice($data[Questioner::COLUMN_PRICE] ?? 0)
            ->save();
    }

    /**
     * @param Questioner $questioner
     * @param array $data
     * @return void
     */
    public function update(Questioner $questioner, array $data): void
    {
        $questioner->setTitle($data[Questioner::COLUMN_TITLE] ?? $questioner->getTitle())
            ->setSlug($data[Questioner::COLUMN_SLUG] ?? $questioner->getSlug())
            ->setPrice($data[Questioner::COLUMN_PRICE] ?? $questioner->getPrice())
            ->save();
    }

    /**
     * @param Questioner $questioner
     * @return void
     */
    public function delete(Questioner $questioner): void
    {
        $questioner->delete();
    }

}
