<?php

namespace App\Http\Requests\Api\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Questioner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /**
         * No user authentication needed for this action
         */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Questioner::COLUMN_TITLE => ['required', 'string', 'max:250',
                Rule::unique(Questioner::getDBTable())->whereNull(BaseModel::COLUMN_DELETED_AT)],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            Questioner::COLUMN_TITLE . '.required' => __("questions/questioner.validation.titleIsRequired"),
            Questioner::COLUMN_TITLE . '.max' => __("questions/questioner.validation.titleIsTooLong"),
            Questioner::COLUMN_TITLE . '.unique' => __("questions/questioner.validation.titleAlreadyExists"),
        ];
    }


}
