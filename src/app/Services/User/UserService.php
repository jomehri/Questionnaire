<?php

namespace App\Services\User;

use App\Services\BaseService;
use App\Repositories\Basic\UserRepository;
use App\Interfaces\Repositories\Basic\IUserRepository;

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
        $this->userRepository->register($data);
    }

}
