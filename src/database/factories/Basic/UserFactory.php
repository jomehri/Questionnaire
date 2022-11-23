<?php

namespace Database\Factories\Basic;

use App\Models\Basic\User;
use Ybazli\Faker\Facades\Faker;
use Database\Factories\BaseFactory;

class UserFactory extends BaseFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * @return array|mixed[]
     */
    public function definition(): array
    {
        return [
            User::COLUMN_FIRST_NAME => Faker::firstName(),
            User::COLUMN_LAST_NAME => Faker::lastName(),
            User::COLUMN_MOBILE => Faker::mobile(),
        ];
    }

    /**
     * @return UserFactory
     */
    public function nullFirstName(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                User::COLUMN_FIRST_NAME => null,
            ];
        });
    }

    /**
     * @return UserFactory
     */
    public function nullLastName(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                User::COLUMN_LAST_NAME => null,
            ];
        });
    }

}
