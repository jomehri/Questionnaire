<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseApiException;

class UserPinHasExpiredException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("basic/user.exception.userPinHasExpired");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
