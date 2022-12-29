<?php

namespace Database\Seeders;

use App\Models\Sale\Coin;
use App\Models\Basic\User;
use Database\Seeders\Basic\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        /**
         * Run all seeders
         */
        $this->call([
            UserSeeder::class,
        ]);
    }
}
