<?php

namespace App\Services\User;

use App\Interfaces\Repositories\Basic\IUserRepository;
use App\Repositories\Basic\UserRepository;
use App\Services\BaseService;

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
        $this->userRepository->register($data['mobile']);
    }

}
