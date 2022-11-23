<?php

namespace App\Repositories\Basic;

use App\Models\Basic\User;
use App\Repositories\BaseRepository;
use App\Interfaces\Repositories\Basic\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User
    {
        return (new User)->first();
    }

    /**
     * @param string $mobile
     * @return User
     */
    public function register(string $mobile): User
    {
        return (new User)->setMobile($mobile)->save();
    }

}
