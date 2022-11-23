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
         * Seed some sample users
         */
        User::factory(10)
            ->create();
    }
}
