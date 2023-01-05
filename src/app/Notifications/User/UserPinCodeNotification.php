<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class UserPinCodeNotification extends BaseNotification
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

    public function getMessage(): string
    {
        return 'some valid texts directly inside notification';
    }

}
