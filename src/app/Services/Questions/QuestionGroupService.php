<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\QuestionGroup;
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
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(int $page): AnonymousResourceCollection
    {
        $items = QuestionGroup::with('questioners')->forPage($page, $this->perPage)->get();

        return QuestionGroupResource::collection($items);
    }

    /**
     * @return int
     */
    public function countTotal(): int
    {
        return QuestionGroup::all()->count();
    }

    /**
     * @param QuestionGroup $questionGroup
     * @return void
     */
    public function delete(QuestionGroup $questionGroup): void
    {
        $questionGroup->delete();
    }

}
