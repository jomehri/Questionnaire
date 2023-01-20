<?php

namespace App\Http\Requests\Api\Answer;

use App\Exceptions\Questions\BuyQuestionGroupFirstException;
use App\Models\Questions\Question;
use App\Models\Questions\UserAnswer;
use App\Http\Requests\Api\BaseRequest;
use App\Models\Questions\UserQuestionGroup;
use Illuminate\Support\Facades\Auth;

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
     */
    public function rules(): array
    {
        $this->throwIfUserNeedsToPayFirst();

        return [
            UserAnswer::COLUMN_ANSWER => ['required'],
        ];
    }

    /**
     * @throws BuyQuestionGroupFirstException
     */
    private function throwIfUserNeedsToPayFirst(): void
    {
        /** @var Question $question */
        $question = $this->route('question');

        $userQuestionGroup = UserQuestionGroup::findByUserAndQuestionGroupId(
            Auth::id(),
            $question->questionGroup->getId()
        );

        if ($question->questionGroup->getPrice() > 0 && (!$userQuestionGroup || !$userQuestionGroup->getBoughtAt())) {
            throw new BuyQuestionGroupFirstException(null, ['price' => number_format($question->questionGroup->getPrice())]);
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
