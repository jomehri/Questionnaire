<?php

namespace App\Repositories\Sale;

use App\Models\BaseModel;
use App\Models\Sale\Coin;
use App\Repositories\BaseRepository;
use App\Interfaces\Repositories\Sale\ICoinRepository;

class CoinRepository extends BaseRepository implements ICoinRepository
{
    /**
     * @param int $id
     * @return Coin
     */
    public function getCoinById(int $id): Coin
    {
        return (new Coin())->where(BaseModel::COLUMN_ID, $id)
            ->first();
    }

    /**
     * @param int $id
     * @return Coin
     */
    public function getCoinByIdWithLockForUpdate(int $id): Coin
    {
        return (new Coin())->where(BaseModel::COLUMN_ID, $id)
            ->lockForUpdate()
            ->first();
    }

    /**
     * @param string $name
     * @return Coin
     */
    public function getCoinByName(string $name): Coin
    {
        return (new Coin())->where(Coin::COLUMN_NAME, $name)
            ->first();
    }

    /**
     * @param string $name
     * @return Coin
     */
    public function getCoinByNameWithLockForUpdate(string $name): Coin
    {
        return (new Coin())->where(Coin::COLUMN_NAME, $name)
            ->lockForUpdate()
            ->first();
    }

    /**
     * @param Coin $coin
     * @return void
     */
    public function updateCoin(Coin $coin): void
    {
        $coin->save();
    }
}
