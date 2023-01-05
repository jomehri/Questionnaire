<?php

namespace App\Notifications\Basic;

use App\Notifications\Channels\KavenegarSmsChannel;
use App\Notifications\Channels\SmsChannels;
use Illuminate\Bus\Queueable;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class KavenegarHealthCheckNotification extends BaseNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toSms($notifiable)
    {
        return (new KavenegarSmsChannel())
            ->from('ObiWan')
            ->to($notifiable->telephone)
            ->line("These aren't the droids you are looking for.");
    }

}
