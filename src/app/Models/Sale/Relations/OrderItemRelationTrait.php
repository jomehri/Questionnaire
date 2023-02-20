<?php

namespace App\Models\Sale\Relations;

use App\Models\Sale\Order;
use App\Models\Questions\Questioner;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Order $order
 */
trait OrderItemRelationTrait
{

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function questioner(): BelongsTo
    {
        return $this->belongsTo(Questioner::class);
    }

}
