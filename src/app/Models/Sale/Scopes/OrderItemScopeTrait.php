<?php

namespace App\Models\Sale\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static static|Builder forQuestioner(int $questionerId)
 * @method static static|Builder forOrder(int $orderId)
 */
trait OrderItemScopeTrait
{

    /**
     * @param Builder $query
     * @param int $questionerId
     * @return void
     */
    public function scopeForQuestioner(Builder $query, int $questionerId): void
    {
        $query->where(static::COLUMN_QUESTIONER_ID, $questionerId);
    }

    /**
     * @param Builder $query
     * @param int $orderId
     * @return void
     */
    public function scopeForOrder(Builder $query, int $orderId): void
    {
        $query->where(static::COLUMN_ORDER_ID, $orderId);
    }

}
