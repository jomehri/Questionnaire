<?php

namespace App\Interfaces\Repositories\Basic;

use App\Models\Basic\User;

interface IUserRepository
{
    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User;

    /**
     * @param int $id
     * @return User
     */
    public function getUserWithLockForUpdate(int $id): User;

    /**
     * @param User $user
     * @return void
     */
    public function updateUser(User $user): void;
}
