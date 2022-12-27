<?php

namespace App\Services\Profile;

use App\Http\Resources\User\UserResource;
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
     * @return UserResource
     */
    public function getUserDetails(): UserResource
    {
        return UserResource::make(Auth::user());
    }

}
