<?php

namespace App\Http\Requests\Api\User;

use App\Models\Basic\User;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginTokenValidation extends FormRequest
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
            User::COLUMN_MOBILE => ['required', 'string', 'min:11', 'max:11', 'regex:/(09)[0-9]{9}/', 'exists:users'],
            User::COLUMN_PIN_CODE => ['required', 'string', 'min:7', 'max:7'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            User::COLUMN_MOBILE . '.exists' => __("basic/user.validation.userNotRegistered"),
            User::COLUMN_MOBILE . '.min' => __("basic/user.validation.mobileCharactersTooLong"),
            User::COLUMN_MOBILE . '.max' => __("basic/user.validation.mobileCharactersTooLong"),
            User::COLUMN_MOBILE . '.regex' => __("basic/user.validation.mobileFormatNotAllowed"),
            User::COLUMN_PIN_CODE . '.required' => __("basic/user.validation.pinIsRequired"),
            User::COLUMN_PIN_CODE . '.min' => __("basic/user.validation.pinLengthNotCorrect"),
            User::COLUMN_PIN_CODE . '.max' => __("basic/user.validation.pinLengthNotCorrect"),
        ];
    }


}
