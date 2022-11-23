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
    const COLUMN_FIRST_NAME = 'first_name';
    const COLUMN_LAST_NAME = 'last_name';
    const COLUMN_MOBILE = 'mobile';
    const COLUMN_PIN_CODE = 'pin_code';

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->{self::COLUMN_FIRST_NAME};
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setFirstName(?string $value): self
    {
        $this->{self::COLUMN_FIRST_NAME} = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->{self::COLUMN_LAST_NAME};
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setLastName(?string $value): self
    {
        $this->{self::COLUMN_LAST_NAME} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->{self::COLUMN_MOBILE};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setMobile(string $value): self
    {
        $this->{self::COLUMN_MOBILE} = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPinCode(): ?string
    {
        return $this->{self::COLUMN_PIN_CODE};
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setPinCode(?string $value): self
    {
        $this->{self::COLUMN_PIN_CODE} = $value;

        return $this;
    }

    /**
     * @param string $mobile
     * @return User|null
     */
    public static function getUserByMobile(string $mobile): ?user
    {
        return (new self)
            ->where(self::COLUMN_MOBILE, $mobile)
            ->first();
    }


}
