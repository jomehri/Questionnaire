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

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->{self::COLUMN_FIRST_NAME};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setFirstName(string $value): self
    {
        $this->{self::COLUMN_FIRST_NAME} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->{self::COLUMN_LAST_NAME};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setLastName(string $value): self
    {
        $this->{self::COLUMN_LAST_NAME} = $value;

        return $this;
    }

}
