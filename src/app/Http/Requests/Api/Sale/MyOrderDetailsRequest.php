<?php

namespace App\Http\Requests\Api\Sale;

use App\Exceptions\Sale\OrderNotForYouException;
use App\Models\Sale\Order;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Support\Facades\Auth;

class MyOrderDetailsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validations rules that apply to the request.
     *
     * @return array
     * @throws OrderNotForYouException
     */
    public function rules(): array
    {
        $this->validateUserOrderPermission();

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
     * @throws OrderNotForYouException
     */
    public function validateUserOrderPermission(): void
    {
        /** @var Order $order */
        $order = $this->route('order');

        /**
         * Users can only see their own orders
         */
        if ($order->getUserId() !== Auth::id()) {
            throw new OrderNotForYouException();
        }
    }

}
