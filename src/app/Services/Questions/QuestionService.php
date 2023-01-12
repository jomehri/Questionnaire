<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionGroup;
use App\Http\Resources\Questions\QuestionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            Question::COLUMN_TITLE => $request->post('title'),
            Question::COLUMN_TYPE => $request->post('type'),
            Question::COLUMN_DESCRIPTION => $request->post('description'),
        ];
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param array $data
     * @return void
     */
    public function store(QuestionGroup $questionGroup, array $data): void
    {
        DB::transaction(function () use ($questionGroup, $data) {
            /**
             * 1- Add new question
             */
            $item = new Question();
            $item->setQuestionGroupId($questionGroup->getId())
                ->setTitle($data[Question::COLUMN_TITLE])
                ->setType($data[Question::COLUMN_TYPE])
                ->setDescription($data[Question::COLUMN_DESCRIPTION])
                ->save();
        });
    }

    /**
     * @param Question $question
     * @param array $data
     * @return void
     */
    public function update(Question $question, array $data): void
    {
        DB::transaction(function () use ($question, $data) {
            $question->setTitle($data[Question::COLUMN_TITLE])
                ->setType($data[Question::COLUMN_TYPE])
                ->setDescription($data[Question::COLUMN_DESCRIPTION])
                ->save();
        });
    }

    /**
     * @param Question $question
     * @return void
     */
    public function delete(Question $question): void
    {
        DB::transaction(function () use ($question) {
            $question->delete();
        });
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(QuestionGroup $questionGroup, int $page): AnonymousResourceCollection
    {
        $items = Question::forQuestionGroup($questionGroup->id)->forPage($page, $this->perPage)->get();

        return QuestionResource::collection($items);
    }

    /**
     * @param QuestionGroup $questionGroup
     * @return int
     */
    public function countTotal(QuestionGroup $questionGroup): int
    {
        return Question::forQuestionGroup($questionGroup->id)->count();
    }

}
