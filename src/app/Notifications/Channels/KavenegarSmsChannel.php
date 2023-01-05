<?php

namespace App\Notifications\Channels;

use Kavenegar\Laravel\Message\KavenegarMessage;
use Throwable;
use Exception;
use App\Models\Basic\SmsMessage;
use Illuminate\Support\Facades\Log;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class KavenegarSmsChannel extends KavenegarBaseNotification
{

    public array $lines = [];
    public string $from;
    public string $to;

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
        $this->to = $to->mobile;

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
            $message = implode("\r\n", $this->lines);
            $receptor = $this->to;

            $result = (new KavenegarMessage($message))
                ->from($sender)
                ->to($receptor);

            dump($result);

            if ($result) {
                $item = new SmsMessage();
                $item->setReceiver($this->to)
                    ->setMessage($message)
                    ->setSent(true)
                    ->save();

                Log::info("Message send through Kavenegar to " . $this->receptor);
            }
        } catch (Throwable $e) {
            Log::error("Kavenegar error!", [$e]);
            throw new Exception("Kavenegar error: " . $e->errorMessage(), []);
        }
    }

}
