<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage users',
            'manage managers',
            'manage customers',
            'manage products',
            'manage orders',
            'view reports',
            'manage own orders',
            'manage own profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        $customer = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions($permissions);

        $manager->syncPermissions([
            'manage customers',
            'manage products',
            'manage orders',
            'view reports',
        ]);

        $customer->syncPermissions([
            'manage own orders',
            'manage own profile',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}