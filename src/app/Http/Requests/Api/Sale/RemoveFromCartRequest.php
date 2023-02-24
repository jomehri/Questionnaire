<?php

namespace App\Http\Requests\Api\Sale;

use App\Exceptions\Sale\OrderItemIdIsRequiredException;
use App\Exceptions\Sale\OrderItemIdNotNumericException;
use App\Exceptions\Sale\OrderItemNotForYouException;
use App\Exceptions\Sale\OrderItemNotFoundException;
use App\Exceptions\Sale\OrderNotOpenException;
use App\Models\Sale\OrderItem;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Support\Facades\Auth;

class RemoveFromCartRequest extends BaseRequest
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
     * @throws OrderItemIdIsRequiredException
     * @throws OrderItemIdNotNumericException
     * @throws OrderItemNotFoundException
     * @throws OrderItemNotForYouException
     * @throws OrderNotOpenException
     */
    public function rules(): array
    {
        $this->verifyOrderItemIsDeletable();
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
     * @throws OrderItemIdIsRequiredException
     * @throws OrderItemIdNotNumericException
     * @throws OrderItemNotFoundException
     * @throws OrderItemNotForYouException
     * @throws OrderNotOpenException
     */
    function verifyOrderItemIsDeletable(): void
    {
        $orderItemId = $this->route('order_item_id');

        if (!$orderItemId) {
            throw new OrderItemIdIsRequiredException();
        }

        if (!is_numeric($orderItemId)) {
            throw new OrderItemIdNotNumericException();
        }

        /** @var OrderItem $orderItem */
        $orderItem = OrderItem::find($orderItemId);

        if (!$orderItem) {
            throw new OrderItemNotFoundException();
        }

        /**
         * Is it not for current user?
         */
        if ($orderItem->order->getUserId() !== Auth::id()) {
            throw new OrderItemNotForYouException();
        }

        /**
         * Is the order not open anymore?
         */
        if (!$orderItem->order->isOpen()) {
            throw new OrderNotOpenException();
        }
    }

}
