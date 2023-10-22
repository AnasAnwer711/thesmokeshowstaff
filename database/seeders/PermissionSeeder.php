<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Permission::create(['name'=>'add host']);
        // Permission::create(['name'=>'edit host']);
        // Permission::create(['name'=>'delete host']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'host']);
        $role2 = Role::create(['name' => 'staff']);
        // $role1->syncPermissions(['add staff', 'edit staff', 'delete staff']);

        $role3 = Role::create(['name' => 'admin']);
        // $role3->syncPermissions(['add host']);

        $role4 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // // create demo users
        $user = \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'display_name' => 'Admin User',
            'name' => 'Admin',
            'nationality_id' => 1,
            'email' => 'admin@thesmokeshowstaff.com',
        ]);
        $user->assignRole($role3);
        
        // create demo users
        // $user = \App\Models\User::factory()->create([
        //     'first_name' => 'Normal',
        //     'last_name' => 'User',
        //     'display_name' => 'Normal User',
        //     'nationality_id' => 1,
        //     'email' => 'user@example.com',
        // ]);
        // $user->assignRole($role2);

        // $user = \App\Models\User::factory()->create([
        //     'first_name' => 'Admin',
        //     'last_name' => 'User',
        //     'display_name' => 'Admin',
        //     'nationality_id' => 1,
        //     'email' => 'admin@example.com',
        // ]);
        // $user->assignRole($role3);

        // $user = \App\Models\User::factory()->create([
        //     'first_name' => 'Super',
        //     'last_name' => 'Admin',
        //     'display_name' => 'Super Admin',
        //     'nationality_id' => 1,
        //     'email' => 'superadmin@example.com',
        // ]);
        // $user->assignRole($role4);
    }
}
