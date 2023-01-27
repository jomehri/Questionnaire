<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsChannels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [SmsChannels::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toSms($notifiable)
    {
        $smsChannel = new SmsChannels();

        return $smsChannel->smsChannel
            ->from($smsChannel->from)
            ->to($notifiable)
            ->template($this->getTemplate())
            ->line($this->getMessage());
    }

    /**
     * Kavimo sms template sender
     *
     * @return array
     */
    public function getTemplate(): array
    {
        return [];
    }
}
