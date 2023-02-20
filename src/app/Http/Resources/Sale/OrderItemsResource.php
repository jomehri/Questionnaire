<?php

namespace App\Http\Resources\Sale;

use App\Models\BaseModel;
use App\Models\Questions\Questioner;
use App\Models\Sale\Order;
use App\Models\Sale\OrderItem;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Questioner $questioner */
        $questioner = Questioner::find($this->{OrderItem::COLUMN_QUESTIONER_ID});

        /** @var Order $this */
        return [
            BaseModel::COLUMN_ID => $this->{BaseModel::COLUMN_ID},
            'questioner' => [
                BaseModel::COLUMN_ID => $questioner->getId(),
                Questioner::COLUMN_TITLE => $questioner->getTitle(),
            ],
            OrderItem::COLUMN_AMOUNT => $this->{OrderItem::COLUMN_AMOUNT},
        ];
    }

}
