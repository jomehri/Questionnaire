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
     * @param string $mobile
     * @return User
     */
    public function register(string $mobile): User;

}
