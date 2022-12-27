<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseApiException;

class UserMobileNotFoundException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("basic/user.exception.userMobileNotFound", ['mobile' => $this->extraData['mobile']]);
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
