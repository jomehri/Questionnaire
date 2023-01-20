<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Questions\UserAnswer;
use App\Models\Questions\QuestionGroup;
use App\Models\Questions\UserQuestionGroup;
use App\Http\Resources\Questions\QuestionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AnswerService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            UserAnswer::COLUMN_ANSWER => $request->post('answer'),
            'user' => Auth::user(),
        ];
    }

    /**
     * @param QuestionGroup $questionGroup
     * @return void
     */
    public function finish(QuestionGroup $questionGroup): void
    {
        DB::transaction(function () use ($questionGroup) {
            $userQuestionGroup = UserQuestionGroup::findByUserAndQuestionGroupId(Auth::id(), $questionGroup->getId());

            $userQuestionGroup->setCompletedAt(Carbon::now())
                ->setStatus(UserQuestionGroup::STATUS_COMPLETED)
                ->save();
        });
    }

    /**
     * @param Question $question
     * @param array $data
     * @return void
     */
    public function store(Question $question, array $data): void
    {
        DB::transaction(function () use ($question, $data) {
            /**
             * 1- Add user question group if not already
             */
            $this->findOrCreateUserQuestionGroup($data['user'], $question);

            /**
             * 2- Add user answer
             */
            $item = $this->firstOrCreateUserAnswer($data['user'], $question);

            $item->setAnswer($data[UserAnswer::COLUMN_ANSWER])
                ->save();
        });
    }

    /**
     * @param $user
     * @param Question $question
     * @return UserQuestionGroup
     */
    function findOrCreateUserQuestionGroup($user, Question $question): UserQuestionGroup
    {
        $item = UserQuestionGroup::forUser($user->getId())->forQuestionGroup(
            $question->getQuestionGroupId()
        )->first();

        if ($item) {
            if (!$item->getStartedAt()) {
                $item->setStatus(UserQuestionGroup::STATUS_STARTED)
                    ->setStartedAt(Carbon::now());
            }

            $item->save();
        } else {
            $item = new UserQuestionGroup();
            $item->setUserId($user->getId())
                ->setQuestionGroupId($question->getQuestionGroupId())
                ->setStatus(UserQuestionGroup::STATUS_STARTED)
                ->setStartedAt(Carbon::now())
                ->save();
        }

        return $item;
    }

    /**
     * @param $user
     * @param Question $question
     * @return UserAnswer
     */
    function firstOrCreateUserAnswer($user, Question $question): UserAnswer
    {
        $item = UserAnswer::forUser($user->getId())->forQuestion($question->getId())->first();

        if (!$item) {
            $item = (new UserAnswer())
                ->setUserId($user->getId())
                ->setQuestionId($question->getId());
        }

        return $item;
    }

}
