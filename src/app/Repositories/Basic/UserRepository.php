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
        return (new User)
            ->first();
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUserWithLockForUpdate(int $id): User
    {
        return (new User)
            ->lockForUpdate()
            ->first();
    }

    /**
     * @param User $user
     * @return void
     */
    public function updateUser(User $user): void
    {
        $user->save();
    }

}
