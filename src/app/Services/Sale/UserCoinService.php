<?php

namespace App\Services\Sale;

use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Services\Sale\IUserCoinService;
use App\Interfaces\Repositories\Sale\ICoinRepository;
use App\Exceptions\Sale\UserBalanceNotEnoughException;
use App\Interfaces\Repositories\Basic\IUserRepository;
use App\Interfaces\Repositories\Sale\IUserCoinRepository;

class UserCoinService extends BaseService implements IUserCoinService
{
    /** @var IUserRepository */
    private IUserRepository $userRepository;

    /** @var IUserCoinRepository */
    private IUserCoinRepository $userCoinRepository;

    /** @var ICoinRepository */
    private ICoinRepository $coinRepository;

    /**
     * @param IUserRepository $userRepository
     * @param ICoinRepository $coinRepository
     * @param IUserCoinRepository $userCoinRepository
     */
    public function __construct(IUserRepository $userRepository, ICoinRepository $coinRepository, IUserCoinRepository $userCoinRepository)
    {
        $this->userRepository = $userRepository;
        $this->coinRepository = $coinRepository;
        $this->userCoinRepository = $userCoinRepository;
    }

    /**
     * @param array $data
     * @return void
     */
    public function purchaseUserCoin(array $data): void
    {
        $userId = $data['userId'];
        $coinName = $data['coinName'];
        $amount = $data['amount'];

        /**
         * Lock coin & user records to prevent race condition
         */
        DB::transaction(function () use ($userId, $coinName, $amount) {

            $coin = $this->coinRepository->getCoinByNameWithLockForUpdate($coinName);
            $user = $this->userRepository->getUserWithLockForUpdate($userId);

            /**
             * Does user have enough balance to purchase this coin?
             */
            if ($amount > $user->getBalance()) {
                throw new UserBalanceNotEnoughException();
            }

            /**
             * Update model objects in their own repositories using Model logic layer
             */
            $this->userRepository->updateUser($user->decreaseBalance($amount * $coin->getPrice()));
            $this->coinRepository->updateCoin($coin->decreaseInStuck($amount));
        });
    }
}
