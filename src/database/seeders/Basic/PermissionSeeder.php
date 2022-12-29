<?php

namespace Database\Seeders\Basic;

use App\Models\Basic\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    /**
     * Create permissions
     *
     * @return void
     */
    public function run(): void
    {
        foreach (User::PERMISSIONS as $permission) {
            Permission::findOrCreate($permission, 'api');
        }
    }
}
