<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SmsChannels
{
    public function __construct()
    {
        $this->channel = match (env("NOTIFICATION_CHANNEL")) {
            'kavenegar' => new KavenegarSmsChannel(),
        };

        dd($this->channel);
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toSms($notifiable);

        $message->send();
    }
}
