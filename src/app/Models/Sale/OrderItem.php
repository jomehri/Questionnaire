<?php

namespace App\Models\Sale;

use App\Models\BaseModel;
use App\Models\Sale\Scopes\OrderItemScopeTrait;
use App\Models\Sale\Relations\OrderItemRelationTrait;

class OrderItem extends BaseModel
{

    use OrderItemRelationTrait, OrderItemScopeTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'order_items';
    }

    /**
     * @return string
     */
    public static function getGroup(): string
    {
        return 'Sale';
    }

    /**
     * Columns
     */
    const COLUMN_ORDER_ID = 'order_id';
    const COLUMN_QUESTIONER_ID = 'questioner_id';
    const COLUMN_AMOUNT = 'amount';

    protected $fillable = [
        self::COLUMN_ORDER_ID,
        self::COLUMN_QUESTIONER_ID,
        self::COLUMN_AMOUNT,
    ];

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->{self::COLUMN_ORDER_ID};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setOrderId(int $value): self
    {
        $this->{self::COLUMN_ORDER_ID} = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuestionerId(): int
    {
        return $this->{self::COLUMN_QUESTIONER_ID};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setQuestionerId(int $value): self
    {
        $this->{self::COLUMN_QUESTIONER_ID} = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->{self::COLUMN_AMOUNT};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setAmount(int $value): self
    {
        $this->{self::COLUMN_AMOUNT} = $value;

        return $this;
    }

}
