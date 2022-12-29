<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Basic\RoleSeeder;
use Database\Seeders\Basic\UserSeeder;
use Database\Seeders\Basic\PermissionSeeder;

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
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
