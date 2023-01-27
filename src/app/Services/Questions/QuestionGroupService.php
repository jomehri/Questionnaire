<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Questions\QuestionGroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionGroupService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            QuestionGroup::COLUMN_TITLE => $request->post('title'),
            QuestionGroup::COLUMN_QUESTIONER_ID => $request->post('questioner_id'),
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        DB::transaction(function () use ($data) {
            $item = new QuestionGroup();
            $item->setTitle($data[QuestionGroup::COLUMN_TITLE])
                ->setQuestionerId($data[QuestionGroup::COLUMN_QUESTIONER_ID])
                ->save();
        });
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param array $data
     * @return void
     */
    public function update(QuestionGroup $questionGroup, array $data): void
    {
        DB::transaction(function () use ($questionGroup, $data) {
            $questionGroup->setTitle($data[QuestionGroup::COLUMN_TITLE] ?? $questionGroup->getTitle())
                ->setQuestionerId($data[QuestionGroup::COLUMN_QUESTIONER_ID] ?? $questionGroup->getQuestionerId())
                ->save();
        });
    }

    /**
     * @param array $filters
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(array $filters, int $page): AnonymousResourceCollection
    {
        $items = QuestionGroup::with('questioner')->forPage($page, $this->perPage);

        $this->scopeFilters($filters, $items);

        $items = $items->get();

        return QuestionGroupResource::collection($items);
    }

    /**
     * @param array $filters
     * @return int
     */
    public function countTotal(array $filters): int
    {
        $items = QuestionGroup::query();

        $this->scopeFilters($filters, $items);

        return $items->count();
    }

    /**
     * @param QuestionGroup $questionGroup
     * @return void
     */
    public function delete(QuestionGroup $questionGroup): void
    {
        $questionGroup->delete();
    }

    /**
     * @param array $filters
     * @param Builder $items
     * @return void
     */
    public function scopeFilters(array $filters, Builder $items): void
    {
        if (!empty($filters['questioner_id'])) {
            $items->forQuestioner($filters['questioner_id']);
        }
    }

}
