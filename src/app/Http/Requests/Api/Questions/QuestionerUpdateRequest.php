<?php

namespace App\Http\Requests\Api\Questions;

use App\Models\BaseModel;
use Illuminate\Validation\Rule;
use App\Models\Questions\Questioner;
use App\Http\Requests\Api\BaseRequest;

class QuestionerUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->authorizeUserRole('admin');
    }

    /**
     * Get the validations rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Questioner::COLUMN_TITLE => ['nullable', 'string', 'max:250',
                Rule::unique(Questioner::getDBTable())
                    ->whereNot(BaseModel::COLUMN_ID, $this->route('questioner')->id)
                    ->whereNull(BaseModel::COLUMN_DELETED_AT)],
            Questioner::COLUMN_SLUG => ['nullable', 'string', 'max:250',
                Rule::unique(Questioner::getDBTable())
                    ->whereNot(BaseModel::COLUMN_ID, $this->route('questioner')->id)
                    ->whereNull(BaseModel::COLUMN_DELETED_AT)],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            Questioner::COLUMN_TITLE . '.max' => __("questions/questioner.validations.titleIsTooLong"),
            Questioner::COLUMN_TITLE . '.unique' => __("questions/questioner.validations.titleAlreadyExists"),
            Questioner::COLUMN_SLUG . '.max' => __("questions/questioner.validations.slugIsTooLong"),
            Questioner::COLUMN_SLUG . '.unique' => __("questions/questioner.validations.slugAlreadyExists"),
        ];
    }


}
