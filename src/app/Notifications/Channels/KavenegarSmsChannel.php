<?php

namespace App\Notifications\Channels;

use Throwable;
use Exception;
use App\Models\Basic\SmsMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

class KavenegarSmsChannel extends KavenegarBaseNotification
{

    public array $lines = [];
    public string $from;
    public string $to;
    public array $template;

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
     * @param $template
     * @return $this
     */
    public function template($template): static
    {
        $this->template = $template;

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

        $message = implode("\r\n", $this->lines);

        try {
            if (sizeof($this->template) > 0) {
                $result = $this->sendFixTemplateSms($message);
            } else {
                $result = $this->sendKhadamatiSms($message);
            }

            if ($result->ok()) {
                $item = new SmsMessage();
                $item->setReceiver($this->to)
                    ->setMessage($message)
                    ->setSent(true)
                    ->save();

            } else {
                Log::error('Kavenegar failed: ' . $result->body(), [$result]);
                throw new Exception('Kavenegar failed: ' . $result->body());
            }
        } catch (Throwable $e) {
            Log::error("Kavenegar error!", [$e]);
            throw new Exception("Kavenegar error: " . $e->getMessage());
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

    /**
     * @param string $message
     * @return Response
     */
    public function sendKhadamatiSms(string $message): Response
    {
        $url = $this->apiUrl . $this->apikey . '/sms/send.json?';

        $data = [
            'sender' => $this->sender,
            'receptor' => $this->to,
            'message' => $message,
        ];

        $url .= http_build_query($data);

        return Http::get($url, $data);
    }

    /**
     * @param string $message
     * @return Response
     */
    public function sendFixTemplateSms(string $message): Response
    {
        $url = $this->apiUrl . $this->apikey . '/sms/send.json?';

        $data = array_merge($this->template, [
            'receptor' => $this->to,
        ]);

        $url .= http_build_query($data);

        Log::info('urllllllllllllllll', [$url, $data]);

        return Http::get($url, $data);
    }

}
