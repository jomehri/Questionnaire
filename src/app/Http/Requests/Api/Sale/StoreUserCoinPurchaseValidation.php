<?php

namespace App\Http\Requests\Api\Sale;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserCoinPurchaseValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /**
         * No user authentication needed for this task (Always true)
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
            'coinName' => ['required', 'exists:coins,name'],
            'amount' => ['required', 'numeric', 'min:' . config('coin.minimum_coins_to_buy')],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'coinName.required' => __("sale/user_coin.validation.noCoinSelected"),
            'coinName.exists' => __("sale/user_coin.validation.selectedCoinDoesNotExist"),
            'amount.required' => __("sale/user_coin.validation.selectAmountOfPurchase"),
            'amount.min' => __("sale/user_coin.validation.selectedAmountOfPurchaseShouldBeMore", ['amount' => config('coin.minimum_coins_to_buy')]),
        ];
    }


}
