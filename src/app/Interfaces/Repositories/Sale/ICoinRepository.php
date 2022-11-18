<?php

namespace App\Interfaces\Repositories\Sale;

use App\Models\Sale\Coin;

interface ICoinRepository
{
    /**
     * @param int $id
     * @return Coin
     */
    public function getCoinById(int $id): Coin;

    /**
     * @param int $id
     * @return Coin
     */
    public function getCoinByIdWithLockForUpdate(int $id): Coin;

    /**
     * @param string $name
     * @return Coin
     */
    public function getCoinByName(string $name): Coin;

    /**
     * @param string $name
     * @return Coin
     */
    public function getCoinByNameWithLockForUpdate(string $name): Coin;

    /**
     * @param Coin $coin
     * @return void
     */
    public function updateCoin(Coin $coin): void;
}
