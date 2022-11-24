<?php

namespace App\Services\User;

use App\Helpers\StringHelper;
use App\Models\Basic\User;
use App\Notifications\User\UserPinCodeNotification;
use App\Services\BaseService;
use App\Repositories\Basic\UserRepository;
use App\Interfaces\Repositories\Basic\IUserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    /** @var UserRepository */
    private IUserRepository $userRepository;

    /**
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return void
     */
    public function register(array $data): void
    {
        /**
         * Generate OTP pin code
         */
        $data[User::COLUMN_PIN_CODE] = StringHelper::randomNumber(7);
        $data[User::COLUMN_PIN_EXPIRE_AT] = Carbon::now()->addMinutes(config('settings.token_expiry_minutes'));

        /**
         * Create user
         */
        $user = $this->userRepository->register($data);

        /**
         * Send pin-code to user's cell phone
         */
        $user->notify(new UserPinCodeNotification());
    }

}
