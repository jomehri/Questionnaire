<?php

namespace App\Models\Sale\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static static|Builder forUser(int $userId)
 * @method static static|Builder open()
 * @method static static|Builder closed()
 * @method static static|Builder paid()
 * @method static static|Builder rejected()
 * @method static static|Builder lastOrder()
 */
trait OrderScopeTrait
{

    /**
     * @param Builder $query
     * @param int $userId
     * @return void
     */
    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where(static::COLUMN_USER_ID, $userId);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeOpen(Builder $query): void
    {
        $query->where(static::COLUMN_STATUS, static::STATUS_OPEN);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where(static::COLUMN_STATUS, static::STATUS_CLOSED);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopePaid(Builder $query): void
    {
        $query->where(static::COLUMN_STATUS, static::STATUS_PAID);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeRejected(Builder $query): void
    {
        $query->where(static::COLUMN_STATUS, static::STATUS_REJECTED);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeLastOrder(Builder $query): void
    {
        $query->oldest('id');
    }

}
