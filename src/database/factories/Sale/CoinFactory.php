<?php

namespace Database\Factories\Sale;

use App\Models\Sale\Coin;
use Database\Factories\BaseFactory;

class CoinFactory extends BaseFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coin::class;

    /**
     * @return array|mixed[]
     */
    public function definition(): array
    {
        return [
            Coin::COLUMN_NAME => $this->faker->word(),
            Coin::COLUMN_IN_STOCK => $this->faker->randomFloat(2, 1000, 5000),
            Coin::COLUMN_PRICE => $this->faker->randomFloat(2, 4, 5),
            Coin::COLUMN_STATUS => $this->faker->randomElement(Coin::STATUSES),
        ];
    }

    /**
     * @return CoinFactory
     */
    public function abanCoin(): CoinFactory
    {
        return $this->state(function (array $attributes) {
            return [
                Coin::COLUMN_NAME => 'ABAN',
                Coin::COLUMN_PRICE => 4,
            ];
        });
    }

    /**
     * @return CoinFactory
     */
    public function enabled(): CoinFactory
    {
        return $this->state(function (array $attributes) {
            return [
                Coin::COLUMN_STATUS => Coin::STATUS_ENABLED,
            ];
        });
    }

}
