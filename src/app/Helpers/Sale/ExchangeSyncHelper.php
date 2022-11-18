<?php

namespace App\Helpers\Sale;

use App\Helpers\BaseHelper;
use Exception;
use RedisClient\ClientFactory;
use App\Jobs\Sale\BuyFromExchangeJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use RedisLock\Exception\InvalidArgumentException;
use RedisLock\RedisLock;

class ExchangeSyncHelper extends BaseHelper
{

    const REDIS_KEY_UN_SYNCED_AMOUNT = 'un_synced_amount_3';

    /**
     * @param string $coinName
     * @param float $amount
     * @return void
     */
    public static function newPurchase(string $coinName, float $amount): void
    {
        /**
         * Increase Un-Synced amount after each purchase
         */
        $totalUnSynced = self::incrementTotalUnSynced($coinName, $amount);

        /**
         * If sum passed the limit => sync with International Exchange services
         */
        if ($totalUnSynced > config("coin.minimum_amount_to_sync")) {
            BuyFromExchangeJob::dispatch($coinName, $totalUnSynced);
        }
    }

    /**
     * RedisLock package from https://github.com/cheprasov/php-redis-lock
     *
     * @param string $coinName
     * @param float $amount
     * @return void
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public static function syncOkWithRedisLock(string $coinName, float $amount): void
    {
        /**
         * Sync carefully, make sure it's locked on Redis
         */
        $Redis = ClientFactory::create([
            'server' => 'tcp://' . env('REDIS_HOST') . ':' . env('REDIS_PORT')
        ]);

        $lock = new RedisLock($Redis, self::getRedisKey($coinName), RedisLock::FLAG_DO_NOT_THROW_EXCEPTIONS);

        /**
         * Acquire lock for 2 sec. If lock has acquired in another thread then
         * we will wait 60 seconds, until another thread release the lock,
         * Otherwise it throws an exception.
         */
        if (!$lock->acquire(2, 60)) {
            throw new Exception('ExchangeSync already Locked');
        }

        /**
         * Deduct synced amount as it's successfully synced
         */
        self::decrementTotalUnSynced($coinName, $amount);

        /**
         * Release lock so another waiting thread (Lock) will be able to
         */
        $lock->release();
    }

    /**
     * Get total un-synced amount
     *
     * @param string $coinName
     * @return float
     */
    public static function getOrCreateTotalUnSyncedValue(string $coinName): float
    {
        $key = self::getRedisKey($coinName);
        return Redis::get($key) ?? 0;
    }

    /**
     * Increment total un-synced amount
     *
     * @param string $coinName
     * @param float $amount
     * @return void
     */
    private static function decrementTotalUnSynced(string $coinName, float $amount): void
    {
        Log::info("synOK", [$coinName, $amount]);
        Redis::decr(self::getRedisKey($coinName), $amount);
    }

    /**
     * Increment total un-synced amount
     *
     * @param string $coinName
     * @param float $amount
     * @return float
     */
    private static function incrementTotalUnSynced(string $coinName, float $amount): float
    {
        Redis::incr(self::getRedisKey($coinName), $amount);

        return self::getOrCreateTotalUnSyncedValue($coinName);
    }

    /**
     * Get redis key, i.e. un_synced_amount.ABAN
     * @param string $coinName
     * @return string
     */
    private static function getRedisKey(string $coinName): string
    {
        return self::REDIS_KEY_UN_SYNCED_AMOUNT . '.' . $coinName;
    }
}
