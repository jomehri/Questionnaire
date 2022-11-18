<?php

namespace App\Models\Basic;

use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;

class User extends BaseModel
{
    use Notifiable;

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public static function getGroup(): string
    {
        return 'Basic';
    }

    /**
     * Columns
     */
    const COLUMN_NAME = 'name';
    const COLUMN_EMAIL = 'email';
    const COLUMN_BALANCE = 'balance';

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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->{self::COLUMN_EMAIL};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setEmail(string $value): self
    {
        if ($value) {
            $value = strtolower($value);
        }

        $this->{self::COLUMN_EMAIL} = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->{self::COLUMN_BALANCE};
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setBalance(float $value): self
    {
        $this->{self::COLUMN_BALANCE} = $value;

        return $this;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function decreaseBalance(float $value): self
    {
        $this->{self::COLUMN_BALANCE} = $this->getBalance() - $value;

        return $this;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function increaseBalance(float $value): self
    {
        $this->{self::COLUMN_BALANCE} = $this->getBalance() + $value;

        return $this;
    }

}
