<?php

namespace App\Services\User;

use App\Models\Basic\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Helpers\StringHelper;
use Illuminate\Support\Carbon;
use App\Repositories\Basic\UserRepository;
use App\Notifications\User\UserPinCodeNotification;
use App\Interfaces\Repositories\Basic\IUserRepository;
use App\Exceptions\User\UserPreviousPinNotExpiredYetException;

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
     * @param Request $request
     * @return array
     */
    public function sanitizeRegisterRequestData(Request $request): array
    {
        return [
            User::COLUMN_FIRST_NAME => $request->post('first_name'),
            User::COLUMN_LAST_NAME => $request->post('last_name'),
            User::COLUMN_MOBILE => $request->post('mobile'),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeLoginRequestData(Request $request): array
    {
        return [
            User::COLUMN_MOBILE => $request->post('mobile'),
        ];
    }

    /**
     * @param string $actionType
     * @param string $mobile
     * @return string
     */
    public function getPinRequestSuccessMessage(string $actionType, string $mobile): string
    {
        $phrase = ($actionType === 'register') ? 'registerSuccess' : 'loginSuccess';
        return __("basic/user.{$phrase}", ['mobile' => $mobile]);
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

    /**
     * @param array $data
     * @return void
     * @throws UserPreviousPinNotExpiredYetException
     */
    public function login(array $data): void
    {
        /**
         * Generate OTP pin code
         */
        $data[User::COLUMN_PIN_CODE] = StringHelper::randomNumber(7);
        $data[User::COLUMN_PIN_EXPIRE_AT] = Carbon::now()->addMinutes(config('settings.token_expiry_minutes'));

        /**
         * Update user
         */
        $user = User::getUserByMobile($data[User::COLUMN_MOBILE]);

        /**
         * Must wait for previous pin expiry to ask for a new one, don't let user generate too many pin codes
         */
        if ($user->getPinExpireAt() > Carbon::now()) {
            $remainingSeconds = $user->getPinExpireAt()->diffInSeconds(Carbon::now());
            throw new UserPreviousPinNotExpiredYetException(null, ['seconds' => $remainingSeconds]);
        }

        $this->userRepository->login($user, $data);

        /**
         * Send pin-code to user's cell phone
         */
        $user->notify(new UserPinCodeNotification());
    }

}
