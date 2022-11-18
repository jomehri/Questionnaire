<?php

namespace App\Interfaces\Services\Sale;

interface IUserCoinService
{
    /**
     * @param array $data
     * @return void
     */
    public function purchaseUserCoin(array $data): void;
}
