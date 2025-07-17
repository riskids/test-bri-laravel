<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->CreateDefaultPermissions();

        /**
         * Create Roles and Assign Permissions to Roles.
         */
        $administrator = Role::create(['id' => '1', 'name' => 'administrator']);
        $administrator->givePermissionTo([
            'view_users',
            'add_users',
            'edit_users',
            'edit_users_permissions',
            'delete_users',
            'restore_users',
            'block_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',
            'restore_roles',
        ]);

        $operational = Role::create(['id' => '2', 'name' => 'operational']);
        $operational->givePermissionTo([
            'view_goods',
            'add_goods',
            'edit_goods',
            'delete_goods',
            'restore_goods'
        ]);

        $sales = Role::create(['id' => '3', 'name' => 'sales']);
        $sales->givePermissionTo(permissions: 'view_goods');
    }

    public function CreateDefaultPermissions()
    {
        // Create Permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $permission) {
            $permission = Permission::make(['name' => $permission]);
            $permission->saveOrFail();
        }
    }
}
