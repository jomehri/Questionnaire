<?php

namespace App\Notifications\User;

use App\Models\Basic\User;
use Illuminate\Bus\Queueable;
use App\Notifications\BaseNotification;

class UserPinCodeNotification extends BaseNotification
{
    use Queueable;

    protected User $user;
    protected string $pinCode;

    /**
     * @param User $user
     * @param string $pinCode
     */
    public function __construct(User $user, string $pinCode)
    {
        $this->user = $user;
        $this->pinCode = $pinCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return
            (($this->user->getFirstName()) ?? 'کاربر') .
            ' عزیز' .
            "\r\n" .
            'کد شما جهت ورود به سایت: ' .
            "\r\n" .
            $this->pinCode;
    }

    /**
     * @return array
     */
    public function getTemplate(): array
    {
        return [
            'template' => 'otpPinCode',
            'token' => $this->user->getFirstName() ?? 'کاربر',
            'token2' => $this->pinCode,
        ];
    }

}
