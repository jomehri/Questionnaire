<?php

namespace Database\Seeders\Basic;

use App\Models\Basic\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{

    /**
     * Create roles
     *
     * @return void
     */
    public function run(): void
    {
        foreach (User::ROLES as $role) {
            $role = Role::findOrCreate($role, 'api');

            $role->givePermissionTo(Permission::all());
        }
    }
}
