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
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $user = new User;

        $user
            ->setFirstName($data[User::COLUMN_FIRST_NAME])
            ->setLastName($data[User::COLUMN_LAST_NAME])
            ->setMobile($data[User::COLUMN_MOBILE])
            ->setPinCode($data[User::COLUMN_PIN_CODE])
            ->setPinExpireAt($data[User::COLUMN_PIN_EXPIRE_AT])
            ->save();

        return $user;
    }

}
