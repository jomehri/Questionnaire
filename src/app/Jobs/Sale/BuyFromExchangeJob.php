<?php

namespace App\Jobs\Sale;

use Throwable;
use App\Jobs\BaseJob;
use Illuminate\Support\Facades\Log;
use App\Helpers\Sale\ExchangeSyncHelper;

class BuyFromExchangeJob extends BaseJob
{
    private string $coinName;
    private float $amount;

    /**
     * @param string $coinName
     * @param float $amount
     */
    public function __construct(string $coinName, float $amount)
    {
        $this->coinName = $coinName;
        $this->amount = $amount;
    }

    /**
     * @return void
     */
    public function handle(): void
    {

        try {
            /**
             * Do the API Request to International Exchange API based on coinName
             * We could use Strategy Design Pattern to select which
             * services should be called
             */

            /**
             * Then updated un-synced count (decrease vale)
             */
            ExchangeSyncHelper::syncOkWithRedisLock($this->coinName, $this->amount);

            return;

        } catch (Throwable $exception) {
            Log::error("Buy from Exchange Failed!", [$exception]);
        }
    }
}
