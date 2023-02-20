<?php

namespace App\Http\Resources\Sale;

use App\Models\BaseModel;
use App\Models\Sale\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserQuestionGroupResource;

class CartResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Order $this */
        return [
            BaseModel::COLUMN_ID => $this->{BaseModel::COLUMN_ID},
            Order::COLUMN_STATUS => $this->{Order::COLUMN_STATUS},
            Order::COLUMN_AMOUNT => $this->{Order::COLUMN_AMOUNT},
            Order::COLUMN_BANK_REF_ID => $this->{Order::COLUMN_BANK_REF_ID},
            Order::COLUMN_PAID_AT => $this->getPaidAt()?->timestamp,
            'orderItems' => OrderItemsResource::collection($this->whenLoaded('orderItems')),
        ];
    }

}
