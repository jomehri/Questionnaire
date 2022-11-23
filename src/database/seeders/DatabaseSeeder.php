<?php

namespace Database\Seeders;

use App\Models\Sale\Coin;
use App\Models\Basic\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seed a sample user
         */
        User::factory(1)
            ->create();
    }
}
