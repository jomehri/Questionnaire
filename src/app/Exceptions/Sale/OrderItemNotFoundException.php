<?php

namespace App\Exceptions\Sale;

use App\Exceptions\BaseApiException;

class OrderItemNotFoundException extends BaseApiException
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __("sale/sale.validations.orderItemNotFound", $this->extraData);
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return 422;
    }
}
