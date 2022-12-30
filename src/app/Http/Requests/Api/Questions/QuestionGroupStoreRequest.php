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
            QuestionGroup::COLUMN_TITLE => ['required', 'string', 'max:250',
                Rule::unique(QuestionGroup::getDBTable())->whereNull(BaseModel::COLUMN_DELETED_AT)],
            'questioner_ids' => ['nullable', 'array'],
            'questioner_ids.*' => ['exists:questioners,id'],
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
            'questioner_ids' . '.array' => __("questions/question_group.validations.questionerIdsMustBeArray"),
            'questioner_ids.*' . '.exists' => __("questions/question_group.validations.questionerIdNotFound"),
        ];
    }


}
