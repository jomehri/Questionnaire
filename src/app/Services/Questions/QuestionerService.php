<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Models\Questions\Questioner;
use App\Http\Resources\Questions\QuestionerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Exceptions\Questions\QuestionerWithQuestionsCantBeDeletedException;

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
        ];
    }

    /**
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(int $page): AnonymousResourceCollection
    {
        $items = Questioner::with('questionGroups')->forPage($page, $this->perPage)->get();

        return QuestionerResource::collection($items);
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
            ->save();
    }

    /**
     * @param Questioner $questioner
     * @param array $data
     * @return void
     */
    public function update(Questioner $questioner, array $data): void
    {
        $questioner->setTitle($data[Questioner::COLUMN_TITLE])
            ->setSlug($data[Questioner::COLUMN_SLUG])
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
