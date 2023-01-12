<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Basic\RoleSeeder;
use Database\Seeders\Basic\UserSeeder;

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
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
