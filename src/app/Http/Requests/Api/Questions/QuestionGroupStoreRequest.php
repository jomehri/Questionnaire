<?php

namespace App\Http\Requests\Api\Questions;

use App\Models\BaseModel;
use App\Models\Questions\Questioner;
use Illuminate\Validation\Rule;
use App\Http\Requests\Api\BaseRequest;
use App\Models\Questions\QuestionGroup;

class QuestionGroupStoreRequest extends BaseRequest
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
            QuestionGroup::COLUMN_TITLE => ['required', 'string', 'max:250',
                Rule::unique(QuestionGroup::getDBTable())
                    ->where(QuestionGroup::COLUMN_QUESTIONER_ID, $this->post('questioner_id'))
                    ->whereNull(BaseModel::COLUMN_DELETED_AT)],
            QuestionGroup::COLUMN_QUESTIONER_ID => ['required', 'integer', 'exists:questioners,id'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            QuestionGroup::COLUMN_TITLE . '.required' => __("questions/question_group.validations.titleIsRequired"),
            QuestionGroup::COLUMN_TITLE . '.max' => __("questions/question_group.validations.titleIsTooLong"),
            QuestionGroup::COLUMN_TITLE . '.unique' => __("questions/question_group.validations.titleAlreadyExists"),
            QuestionGroup::COLUMN_QUESTIONER_ID . '.required' => __("questions/question_group.validations.questionerIdIsRequired"),
            QuestionGroup::COLUMN_QUESTIONER_ID . '.integer' => __("questions/question_group.validations.questionerIdMustBeInteger"),
            QuestionGroup::COLUMN_QUESTIONER_ID . '.exists' => __("questions/question_group.validations.questionerDoesNotExist"),
        ];
    }


}
