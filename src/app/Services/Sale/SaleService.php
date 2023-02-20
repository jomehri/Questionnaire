<?php

namespace App\Services\Sale;

use App\Http\Resources\Sale\CartResource;
use App\Models\Questions\Questioner;
use App\Models\Sale\Order;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Models\Sale\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            OrderItem::COLUMN_QUESTIONER_ID => $request->post('questioner_id'),
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function addToCart(array $data): void
    {
        DB::transaction(function () use ($data) {
            /**
             * firstOrCreate Order
             * @var Order $order
             */
            $order = Order::firstOrCreate([
                Order::COLUMN_USER_ID => Auth::id(),
                Order::COLUMN_STATUS => Order::STATUS_OPEN,
            ]);

            /**
             * firstOrCreate OrderItem
             * @var OrderItem $orderItem
             */
            OrderItem::firstOrCreate([
                OrderItem::COLUMN_ORDER_ID => $order->getId(),
                OrderItem::COLUMN_QUESTIONER_ID => $data[OrderItem::COLUMN_QUESTIONER_ID],
                OrderItem::COLUMN_AMOUNT => Questioner::getQuestionerPrice($data[OrderItem::COLUMN_QUESTIONER_ID]),
            ]);

            $this->recalculateOrderAmount($order);
        });
    }

    /**
     * @param Order $order
     * @return void
     */
    private function recalculateOrderAmount(Order $order): void
    {
        $totalAmount = OrderItem::forOrder($order->getId())->sum(OrderItem::COLUMN_AMOUNT);
        $order->setAmount($totalAmount)->save();
    }

    /**
     * @return CartResource|null
     */
    public function getCurrentCartDetails(): null|CartResource
    {
        $order = Order::forUser(Auth::id())->with('orderItems')->first();

        if (!$order) {
            return null;
        }

        return CartResource::make($order);
    }

}
