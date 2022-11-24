<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseApiException;

class UserPreviousPinNotExpiredYetException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("basic/user.exception.previousPinNotExpiredYet", ['seconds' => $this->extraData['seconds']]);
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
