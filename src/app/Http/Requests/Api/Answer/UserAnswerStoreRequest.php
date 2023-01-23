<?php

namespace App\Http\Requests\Api\Answer;

use App\Models\Questions\Question;
use App\Models\Questions\Questioner;
use Illuminate\Support\Facades\Auth;
use App\Models\Questions\UserAnswer;
use App\Http\Requests\Api\BaseRequest;
use App\Models\Questions\QuestionGroup;
use App\Models\Questions\UserQuestionGroup;
use App\Exceptions\Questions\BuyQuestionGroupFirstException;
use App\Exceptions\Questions\AnsweringAlreadyFinishedException;
use App\Exceptions\Questions\QuestionIsNotLinkedToSelectedQuestionGroupException;

class UserAnswerStoreRequest extends BaseRequest
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
     * Get the validations rules that apply to the request.
     *
     * @return array
     * @throws BuyQuestionGroupFirstException
     * @throws QuestionIsNotLinkedToSelectedQuestionGroupException
     * @throws AnsweringAlreadyFinishedException
     */
    public function rules(): array
    {
        $this->throwIfQuestionDoesNotBelongToQuestionGroup();
        $this->throwIfUserCompletedThisQuestionerBefore();
        $this->throwIfUserNeedsToPayFirst();

        return [
            UserAnswer::COLUMN_ANSWER => ['required'],
        ];
    }

    /**
     * @throws QuestionIsNotLinkedToSelectedQuestionGroupException
     */
    private function throwIfQuestionDoesNotBelongToQuestionGroup(): void
    {
        /** @var Questioner $questioner */
        $questioner = $this->route('questioner');

        /** @var Question $question */
        $question = $this->route('question');

        if ($questioner->getId() !== $question->questionGroup->questioner->getId()) {
            throw new QuestionIsNotLinkedToSelectedQuestionGroupException();
        }
    }

    /**
     * @throws AnsweringAlreadyFinishedException
     */
    private function throwIfUserCompletedThisQuestionerBefore(): void
    {
        /** @var Questioner $questioner */
        $questioner = $this->route('questioner');

        $userQuestionGroup = UserQuestionGroup::forUser(Auth::id())->forQuestioner($questioner->getId())->first();

        if ($userQuestionGroup?->getCompletedAt()) {
            throw new AnsweringAlreadyFinishedException();
        }
    }

    /**
     * @throws BuyQuestionGroupFirstException
     */
    private function throwIfUserNeedsToPayFirst(): void
    {
        /** @var Questioner $questioner */
        $questioner = $this->route('questioner');

        $userQuestionGroup = UserQuestionGroup::findByUserAndQuestionerId(
            Auth::id(),
            $questioner->getId()
        );

        if ($questioner->getPrice() > 0 && (!$userQuestionGroup || !$userQuestionGroup->getBoughtAt())) {
            throw new BuyQuestionGroupFirstException(null, ['price' => number_format($questioner->getPrice())]);
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


}
