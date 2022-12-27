<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseApiException;

class UserPinIsIncorrectException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("basic/user.exception.userPinIsIncorrect");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
