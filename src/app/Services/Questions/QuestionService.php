<?php

namespace App\Services\Questions;

use App\Models\Questions\QuestionGroup;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Question;

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

}
