<?php

namespace App\Http\Requests\Api\Questions;

use App\Http\Requests\Api\BaseRequest;
use App\Exceptions\Questions\QuestionGroupWithQuestionsCantBeDeletedException;

class QuestionGroupDeleteRequest extends BaseRequest
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
     * @throws QuestionGroupWithQuestionsCantBeDeletedException
     */
    public function rules(): array
    {
        $this->throwIfQuestionGroupHasDependencies();

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
     * @throws QuestionGroupWithQuestionsCantBeDeletedException
     */
    public function throwIfQuestionGroupHasDependencies(): void
    {
        // TODO @aliJo check no question groups are assigned to this questioner, else throw error
        if (1 === 2) {
            throw new QuestionGroupWithQuestionsCantBeDeletedException();
        }
    }


}
