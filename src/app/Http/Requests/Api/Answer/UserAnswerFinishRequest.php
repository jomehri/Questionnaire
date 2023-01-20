<?php

namespace App\Http\Requests\Api\Answer;

use App\Exceptions\Questions\AnsweringAlreadyFinishedException;
use App\Exceptions\Questions\AnsweringNotStartedYetException;
use App\Models\Questions\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Questions\UserAnswer;
use App\Http\Requests\Api\BaseRequest;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Questions\UserQuestionGroup;
use App\Exceptions\Questions\BuyQuestionGroupFirstException;
use App\Exceptions\Questions\AnswerAllRequiredQuestionsFirstException;

class UserAnswerFinishRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     * @throws AnswerAllRequiredQuestionsFirstException
     * @throws AnsweringNotStartedYetException
     * @throws BuyQuestionGroupFirstException
     * @throws AnsweringAlreadyFinishedException
     */
    public function rules(): array
    {
        list($questionGroup, $userQuestionGroup) = $this->extractQuestionGroup();

        $this->throwIfNotStartedYet($questionGroup, $userQuestionGroup);
        $this->throwIfAlreadyFinished($questionGroup, $userQuestionGroup);
        $this->throwIfUserNeedsToPayFirst($questionGroup, $userQuestionGroup);
        $this->throwIfFoundUnansweredRequiredQuestions();

        return [];
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param UserQuestionGroup|null $userQuestionGroup
     * @return void
     * @throws AnsweringNotStartedYetException
     */
    private function throwIfNotStartedYet(QuestionGroup $questionGroup, ?UserQuestionGroup $userQuestionGroup): void
    {
        if (!$userQuestionGroup || $userQuestionGroup->notStartedYet()) {
            throw new AnsweringNotStartedYetException();
        }
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param UserQuestionGroup|null $userQuestionGroup
     * @return void
     * @throws AnsweringAlreadyFinishedException
     */
    private function throwIfAlreadyFinished(QuestionGroup $questionGroup, ?UserQuestionGroup $userQuestionGroup): void
    {
        if ($userQuestionGroup->isCompleted()) {
            throw new AnsweringAlreadyFinishedException();
        }
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param UserQuestionGroup|null $userQuestionGroup
     * @return void
     * @throws BuyQuestionGroupFirstException
     */
    private function throwIfUserNeedsToPayFirst(
        QuestionGroup $questionGroup,
        ?UserQuestionGroup $userQuestionGroup
    ): void {
        /**
         * User paid checker
         */
        if ($questionGroup->getPrice() > 0 && !$userQuestionGroup->getBoughtAt()) {
            throw new BuyQuestionGroupFirstException(
                null,
                ['price' => number_format($questionGroup->getPrice())]
            );
        }
    }

    /**
     * @return void
     * @throws AnswerAllRequiredQuestionsFirstException
     */
    private function throwIfFoundUnansweredRequiredQuestions(): void
    {
        /** @var QuestionGroup $questionGroup */
        $questionGroup = $this->route('question_group');

        /**
         * Required questions checker
         */
        $unansweredRequiredQuestionIds = Question::required()->forQuestionGroup(
            $questionGroup->getId()
        )->whereDoesntHave('userAnswers', function (Builder $query) {
            $query->where('user_id', Auth::id());
        })->pluck('id')->toArray();

        if (!empty($unansweredRequiredQuestionIds)) {
            throw new AnswerAllRequiredQuestionsFirstException(
                null,
                ['ids' => implode(", ", $unansweredRequiredQuestionIds)]
            );
        }
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            UserAnswer::COLUMN_ANSWER . '.required' => __("answers/answer.validations.answerIsRequired"),
        ];
    }

    /**
     * @return array
     */
    private function extractQuestionGroup(): array
    {
        /** @var QuestionGroup $questionGroup */
        $questionGroup = $this->route('question_group');

        $userQuestionGroup = UserQuestionGroup::findByUserAndQuestionGroupId(
            Auth::id(),
            $questionGroup->getId()
        );
        return array($questionGroup, $userQuestionGroup);
    }


}
