<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Notifications\Channels\SmsChannels;
use Illuminate\Notifications\Notification;
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
    public function via($notifiable): array
    {
        return [SmsChannels::class];
    }
}
