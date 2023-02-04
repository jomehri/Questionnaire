<?php

namespace App\Services\Questions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
            Question::COLUMN_OPTIONS => $request->post('options'),
            Question::COLUMN_DESCRIPTION => $request->post('description'),
            Question::COLUMN_IS_REQUIRED => $request->post('is_required'),
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
                ->setOptions($data[Question::COLUMN_OPTIONS] ?? null)
                ->setDescription($data[Question::COLUMN_DESCRIPTION])
                ->setIsRequired((bool)$data[Question::COLUMN_IS_REQUIRED])
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
            $question->setTitle($data[Question::COLUMN_TITLE] ?? $question->getTitle())
                ->setType($data[Question::COLUMN_TYPE] ?? $question->getType())
                ->setOptions($data[Question::COLUMN_OPTIONS] ?? $question->getOptions())
                ->setDescription($data[Question::COLUMN_DESCRIPTION] ?? $question->getDescription())
                ->setIsRequired(
                    isset($data[Question::COLUMN_IS_REQUIRED]) ? (bool)$data[Question::COLUMN_IS_REQUIRED] : $question->getIsRequired(
                    )
                )
                ->save();
        });
    }

    /**
     * @param Question $question
     * @param int|null $userId
     * @return Model|Question|Builder|null
     */
    public function loadQuestionWithAnswer(Question $question, ?int $userId): Model|Question|Builder|null
    {
        if (!$userId) {
            return $question;
        }

        return $question::with([
            'userAnswer' => function ($query) use ($question, $userId) {
                $query->where('user_id', $userId)
                    ->where('question_id', $question->getId());
            }
        ])->first();
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
     * @param int|null $userId
     * @return AnonymousResourceCollection
     */
    public function getAll(QuestionGroup $questionGroup, int $page, ?int $userId): AnonymousResourceCollection
    {
        $items = Question::forQuestionGroup($questionGroup->id)->with([
            'userAnswer' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])->forPage($page, $this->perPage)->get();

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
