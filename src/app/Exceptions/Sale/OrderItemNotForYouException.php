<?php

namespace App\Exceptions\Sale;

use App\Exceptions\BaseApiException;

class OrderItemNotForYouException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("sale/sale.validations.orderItemNotForYou", $this->extraData);
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
