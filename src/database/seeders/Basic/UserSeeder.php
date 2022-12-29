<?php

namespace Database\Seeders\Basic;

use App\Models\Basic\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /** @var array $users */
    private array $users = [
        [
            User::COLUMN_FIRST_NAME => 'علی',
            User::COLUMN_LAST_NAME => 'دلالی',
            User::COLUMN_MOBILE => '09339279298',
        ],
        [
            User::COLUMN_FIRST_NAME => 'علی',
            User::COLUMN_LAST_NAME => 'جمهری',
            User::COLUMN_MOBILE => '09352770177',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->users as $user) {
            User::firstOrCreate($user);
        }
    }
}
