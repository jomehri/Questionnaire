<?php

namespace App\Exceptions\Sale;

use App\Exceptions\BaseApiException;

class UserBalanceNotEnoughException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("basic/user.exception.userBalanceNotEnough");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 403;
    }
}
