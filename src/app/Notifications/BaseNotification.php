<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Notifications\Channels\SmsChannels;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Channels\KavenegarSmsChannel;

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
    public function toSms($notifiable): KavenegarSmsChannel
    {
        return (new KavenegarSmsChannel())
            ->from('ObiWan')
            ->to($notifiable)
            ->line($this->getMessage());
    }
}
