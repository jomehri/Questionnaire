<?php

namespace App\Models\Basic;

use App\Models\BaseModel;

class SmsMessage extends BaseModel
{

    /**
     * @return string
     */
    public static function getDBTable(): string
    {
        return 'sms_messages';
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
    const COLUMN_RECEIVER = 'receiver';
    const COLUMN_MESSAGE = 'message';
    const COLUMN_SENT = 'sent';

    /**
     * @return string
     */
    public function getReceiver(): string
    {
        return $this->{self::COLUMN_RECEIVER};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setReceiver(string $value): self
    {
        $this->{self::COLUMN_RECEIVER} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->{self::COLUMN_MESSAGE};
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setMessage(string $value): self
    {
        $this->{self::COLUMN_MESSAGE} = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSent(): bool
    {
        return (bool)$this->{self::COLUMN_SENT};
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setSent(bool $value): self
    {
        $this->{self::COLUMN_SENT} = $value;

        return $this;
    }

}
