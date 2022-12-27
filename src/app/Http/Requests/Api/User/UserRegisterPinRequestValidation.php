<?php

namespace App\Http\Requests\Api\User;

use App\Models\Basic\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterPinRequestValidation extends FormRequest
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
            User::COLUMN_FIRST_NAME => ['string', 'nullable', 'max:50'],
            User::COLUMN_LAST_NAME => ['string', 'nullable', 'max:100'],
            User::COLUMN_MOBILE => ['required', 'string', 'min:11', 'max:11', 'unique:users', 'regex:/(09)[0-9]{9}/'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            User::COLUMN_FIRST_NAME . '.max' => __("basic/user.validation.firstNameTooLong"),
            User::COLUMN_LAST_NAME . '.max' => __("basic/user.validation.lastNameTooLong"),
            User::COLUMN_MOBILE . '.unique' => __("basic/user.validation.mobileNotUnique"),
            User::COLUMN_MOBILE . '.min' => __("basic/user.validation.mobileCharactersTooLong"),
            User::COLUMN_MOBILE . '.max' => __("basic/user.validation.mobileCharactersTooLong"),
            User::COLUMN_MOBILE . '.regex' => __("basic/user.validation.mobileFormatNotAllowed"),
        ];
    }


}
