<?php

namespace App\Http\Requests\Api\Questions;

use App\Models\Questions\Questioner;
use App\Http\Requests\Api\BaseRequest;
use App\Exceptions\Questions\QuestionerWithQuestionsCantBeDeletedException;

class QuestionDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->authorizePermission('admin');
    }

    /**
     * Get the validations rules that apply to the request.
     *
     * @return array
     * @throws QuestionerWithQuestionsCantBeDeletedException
     */
    public function rules(): array
    {
        $this->throwIfQuestionHasAnswers();

        return [];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws QuestionerWithQuestionsCantBeDeletedException
     */
    public function throwIfQuestionHasAnswers(): void
    {
        /** @var Questioner $questioner */
        $question = $this->route('question');

        /**
         * If there are answers attached to this question don't let it get deleted
         * TODO @aliJo
         */
//        if ($questioner->questionGroups()->get()->count()) {
//            throw new QuestionerWithQuestionsCantBeDeletedException();
//        }
    }


}
