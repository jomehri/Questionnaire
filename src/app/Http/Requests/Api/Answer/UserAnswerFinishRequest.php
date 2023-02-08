<?php

namespace App\Http\Requests\Api\Answer;

use App\Models\Questions\Question;
use App\Models\Questions\Questioner;
use Illuminate\Support\Facades\Auth;
use App\Models\Questions\UserAnswer;
use App\Http\Requests\Api\BaseRequest;
use App\Models\Questions\QuestionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Questions\UserQuestionGroup;
use App\Exceptions\Questions\BuyQuestionGroupFirstException;
use App\Exceptions\Questions\AnsweringNotStartedYetException;
use App\Exceptions\Questions\AnsweringAlreadyFinishedException;
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
        list($questioner, $userQuestionGroup) = $this->extractQuestionGroup();

        $this->throwIfNotStartedYet($questioner, $userQuestionGroup);
        $this->throwIfAlreadyFinished($questioner, $userQuestionGroup);
        $this->throwIfUserNeedsToPayFirst($questioner, $userQuestionGroup);
        $this->throwIfFoundUnansweredRequiredQuestions();

        return [];
    }

    /**
     * @param Questioner $questioner
     * @param UserQuestionGroup|null $userQuestionGroup
     * @return void
     * @throws AnsweringNotStartedYetException
     */
    private function throwIfNotStartedYet(Questioner $questioner, ?UserQuestionGroup $userQuestionGroup): void
    {
        if (!$userQuestionGroup || $userQuestionGroup->notStartedYet()) {
            throw new AnsweringNotStartedYetException();
        }
    }

    /**
     * @param Questioner $questioner
     * @param UserQuestionGroup|null $userQuestionGroup
     * @return void
     * @throws AnsweringAlreadyFinishedException
     */
    private function throwIfAlreadyFinished(Questioner $questioner, ?UserQuestionGroup $userQuestionGroup): void
    {
        if ($userQuestionGroup->isCompleted()) {
            throw new AnsweringAlreadyFinishedException();
        }
    }

    /**
     * @param Questioner $questioner
     * @param UserQuestionGroup|null $userQuestionGroup
     * @return void
     * @throws BuyQuestionGroupFirstException
     */
    private function throwIfUserNeedsToPayFirst(
        Questioner $questioner,
        ?UserQuestionGroup $userQuestionGroup
    ): void {
        /**
         * User paid checker
         */
        if ($questioner->getPrice() > 0 && !$userQuestionGroup->getBoughtAt()) {
            throw new BuyQuestionGroupFirstException(
                null,
                ['price' => number_format($questioner->getPrice())]
            );
        }
    }

    /**
     * @return void
     * @throws AnswerAllRequiredQuestionsFirstException
     */
    private function throwIfFoundUnansweredRequiredQuestions(): void
    {
        /** @var Questioner $questioner */
        $questioner = $this->route('questioner');

        if (!$questioner->questionGroups) {
            return;
        }


        /**
         * Required questions checker
         */
        $unansweredRequiredQuestionIds = Question::required()->forQuestioner(
            $questioner->getId()
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
        /** @var Questioner $questioner */
        $questioner = $this->route('questioner');

        $userQuestionGroup = UserQuestionGroup::findByUserAndQuestionerId(
            Auth::id(),
            $questioner->getId()
        );
        return array($questioner, $userQuestionGroup);
    }


}
