<?php

namespace App\Notifications\Basic;

use Illuminate\Bus\Queueable;
use App\Notifications\BaseNotification;

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
     * @return string
     */
    public function getMessage(): string
    {
        return 'کاوه نگار بالاست و اس ام اس با موفقیت ارسال می شود.';
    }

}
