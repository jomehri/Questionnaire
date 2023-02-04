<?php

namespace App\Http\Requests\Api\Questions;

use App\Http\Requests\Api\BaseRequest;
use App\Exceptions\Questions\QuestionerWithQuestionsCantBeDeletedException;
use Illuminate\Support\Facades\Request;

class QuestionGetRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /**
         * If user is trying to see other user's answers, he must be admin
         */
        if (Request::get('userId')) {
            return $this->authorizeUserRole('admin');
        }

        return true;
    }

    /**
     * Get the validations rules that apply to the request.
     *
     * @return array
     * @throws QuestionerWithQuestionsCantBeDeletedException
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

}
