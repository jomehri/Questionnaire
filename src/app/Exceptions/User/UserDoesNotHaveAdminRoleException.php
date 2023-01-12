<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseApiException;

class UserDoesNotHaveAdminRoleException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("basic/user.exception.userDoesNotHaveAdminRole");
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
