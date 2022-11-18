<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class BaseFactory extends Factory implements IBaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public abstract function definition(): array;
}
