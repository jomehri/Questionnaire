<?php

namespace Database\Factories\Basic;

use App\Models\Basic\User;
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
            User::COLUMN_NAME => $this->faker->name(),
            User::COLUMN_EMAIL => $this->faker->unique()->safeEmail(),
            User::COLUMN_BALANCE => $this->faker->randomFloat(2, 100, 1000),
        ];
    }

}
