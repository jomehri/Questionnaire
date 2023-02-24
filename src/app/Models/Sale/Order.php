<?php

namespace App\Models\Sale;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Sale\Scopes\OrderScopeTrait;
use App\Models\Sale\Relations\OrderRelationTrait;

class Order extends BaseModel
{

    use OrderRelationTrait, OrderScopeTrait;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'orders';
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
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_AMOUNT = 'amount';
    const COLUMN_STATUS = 'status';
    const COLUMN_BANK_REF_ID = 'bank_ref_id';
    const COLUMN_PAID_AT = 'paid_at';

    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';
    const STATUS_PAID = 'paid';
    const STATUS_REJECTED = 'rejected';
    const STATUSES = [
        self::STATUS_OPEN => self::STATUS_OPEN,
        self::STATUS_CLOSED => self::STATUS_CLOSED,
        self::STATUS_PAID => self::STATUS_PAID,
        self::STATUS_REJECTED => self::STATUS_REJECTED,
    ];

    protected $fillable = [
        self::COLUMN_USER_ID,
    ];

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->{self::COLUMN_USER_ID};
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->{self::COLUMN_USER_ID} = $value;

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

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->{self::COLUMN_STATUS};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setStatus(string $value): self
    {
        $this->{self::COLUMN_STATUS} = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBankRefId(): null|string
    {
        return $this->{self::COLUMN_BANK_REF_ID};
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setBankRefId(null|string $value): self
    {
        $this->{self::COLUMN_BANK_REF_ID} = $value;

        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getPaidAt(): null|Carbon
    {
        if (!$this->{self::COLUMN_PAID_AT}) {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_PAID_AT});
    }

    /**
     * @param Carbon|null $value
     *
     * @return $this
     */
    public function setPaidAt(null|Carbon $value): self
    {
        $this->{self::COLUMN_PAID_AT} = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->getStatus() === self::STATUS_OPEN;
    }

}
