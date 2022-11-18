<?php

namespace App\Models\Sale;

use App\Models\BaseModel;

class Coin extends BaseModel
{

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'coins';
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
    const COLUMN_NAME = 'name';
    const COLUMN_IN_STOCK = 'in_stock';
    const COLUMN_STATUS = 'status';
    const COLUMN_PRICE = 'price';

    /**
     * Enums
     */
    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';
    const STATUSES = [
        self::STATUS_ENABLED => self::STATUS_ENABLED,
        self::STATUS_DISABLED => self::STATUS_DISABLED,
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->{self::COLUMN_NAME};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->{self::COLUMN_NAME} = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getInStock(): float
    {
        return $this->{self::COLUMN_IN_STOCK};
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setInStock(float $value): self
    {
        $this->{self::COLUMN_IN_STOCK} = $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function decreaseInStuck(float $value): self
    {
        $this->{self::COLUMN_IN_STOCK} = $this->getInStock() - $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function increaseInStuck(float $value): self
    {
        $this->{self::COLUMN_IN_STOCK} = $this->getInStock() + $value;

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
     * @return float
     */
    public function getPrice(): float
    {
        return $this->{self::COLUMN_PRICE};
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setPrice(float $value): self
    {
        $this->{self::COLUMN_PRICE} = $value;

        return $this;
    }

}
