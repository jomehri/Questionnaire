<?php

namespace App\Notifications\Channels;

use Throwable;
use Exception;
use App\Models\Basic\SmsMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
        $this->apiUrl = config("kavenegar.url");
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
        if ($this->isSmsDataIncomplete()) {
            Log::error('SMS sending data not correct!', [$this->from, $this->to, $this->lines]);
            throw new Exception('SMS sending data not correct!');
        }

        if ($this->isKavenegarConfigIncomplete()) {
            Log::error('SMS config not correct!', [$this->apiUrl, $this->apikey, $this->sender, $this->receptor]);
            throw new Exception('SMS config not correct!');
        }

        try {
            $url = $this->apiUrl . $this->apikey . '/sms/send.json?';

            $message = implode("\r\n", $this->lines);

            $data = [
                'sender' => $this->sender,
                'receptor' => $this->to,
                'message' => $message,
            ];

            $url .= http_build_query($data);

            $result = Http::get($url, $data);

            if ($result->ok()) {
                $item = new SmsMessage();
                $item->setReceiver($this->to)
                    ->setMessage($message)
                    ->setSent(true)
                    ->save();

                Log::info("Message sent successfully through Kavenegar to " . $this->receptor);
            } else {
                Log::error('Kavenegar failed: ' . $result->body(), [$result]);
                throw new Exception('Kavenegar failed: ' . $result->body());
            }
        } catch (Throwable $e) {
            Log::error("Kavenegar error!", [$e]);
            throw new Exception("Kavenegar error: " . $e->errorMessage(), []);
        }
    }

    /**
     * @return bool
     */
    public function isKavenegarConfigIncomplete(): bool
    {
        return !$this->apiUrl || !$this->apikey || !$this->sender || !$this->receptor;
    }

    /**
     * @return bool
     */
    public function isSmsDataIncomplete(): bool
    {
        return !$this->from || !$this->to || !count($this->lines);
    }

}
