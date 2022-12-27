<?php

namespace App\Services\Profile;

use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\Basic\IUserRepository;

class ProfileService extends BaseService
{

    /**
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     */
    public function getUserDetails(): array
    {
        dd(Auth::id());
    }

}
