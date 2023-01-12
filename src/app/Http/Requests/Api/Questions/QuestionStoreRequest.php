<?php

namespace App\Http\Requests\Api\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Question;
use Illuminate\Validation\Rule;
use App\Models\Questions\Questioner;
use App\Http\Requests\Api\BaseRequest;

class QuestionStoreRequest extends BaseRequest
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
     */
    public function rules(): array
    {
        return [
            Question::COLUMN_TITLE => ['required', 'string', 'max:250'],
            Question::COLUMN_TYPE => ['required', 'string', 'max:250'],
            Question::COLUMN_DESCRIPTION => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            Question::COLUMN_TITLE . '.required' => __("questions/question.validations.titleIsRequired"),
            Question::COLUMN_TITLE . '.max' => __("questions/question.validations.titleIsTooLong"),
            Question::COLUMN_TYPE . '.required' => __("questions/question.validations.typeIsRequired"),
            Question::COLUMN_TYPE . '.max' => __("questions/question.validations.typeIsTooLong"),
            Question::COLUMN_DESCRIPTION . '.required' => __("questions/question.validations.descriptionIsRequired"),
        ];
    }


}
