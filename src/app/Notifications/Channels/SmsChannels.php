<?php

namespace App\Notifications\Channels;

use Exception;
use Illuminate\Notifications\Notification;

class SmsChannels
{

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $notificationChannel = config("settings.notification_channel");

        if (!$notificationChannel) {
            throw new Exception("Notification channel not selected!");
        }

        $this->smsChannel = match ($notificationChannel) {
            'kavenegar' => new KavenegarSmsChannel(),
        };

        $this->setFrom();
    }

    /**
     * @return void
     */
    public function setFrom(): void
    {
        $this->from = $this->smsChannel->sender;
    }

    /**
     * @return void
     */
    public function setTemplate(): void
    {
        $this->template = $this->smsChannel->template;
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
