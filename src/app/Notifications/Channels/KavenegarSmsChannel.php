<?php

namespace App\Notifications\Channels;

use Throwable;
use Exception;
use Kavenegar;
use App\Models\Basic\SmsMessage;
use Illuminate\Support\Facades\Log;

class KavenegarSmsChannel
{
    use Kavenegar;

    protected array $lines = [];
    protected string $from;
    protected string $to;

    /**
     * @param array $lines
     */
    public function __construct(array $lines = [])
    {
        $this->lines = $lines;
        $this->apikey = config("kavenegar.apikey");
        $this->sender = config("kavenegar.sender");
        $this->receptor = config("kavenegar.receptor");

        return $this;
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param $to
     * @return $this
     */
    public function to($to): static
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param string $line
     * @return $this
     */
    public function line(string $line = ''): static
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function send(): void
    {
        if (!$this->from || !$this->to || !count($this->lines)) {
            throw new Exception('SMS config not correct!');
        }

        try {
            $sender = $this->sender;

            $message = $this->lines;

            $receptor = [$this->receptor];

            $result = Kavenegar::Send($sender, $receptor, $message);

            if ($result) {
                SmsMessage::creat([
                    SmsMessage::COLUMN_RECEIVER => $this->receptor,
                    SmsMessage::COLUMN_MESSAGE => $this->lines,
                    SmsMessage::COLUMN_SENT => true,
                ]);
            }
        } catch (Throwable $e) {
            Log::error("Kavenegar error!", [$e]);
            throw new Exception("Kavenegar error: " . $e->errorMessage(), []);
        }
    }

}
