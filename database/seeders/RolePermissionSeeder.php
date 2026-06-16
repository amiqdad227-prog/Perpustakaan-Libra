<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view books', 'create books', 'update books', 'delete books', 'restore books', 'force delete books',
            'view categories', 'create categories', 'update categories', 'delete categories', 'restore categories', 'force delete categories',
            'view members', 'create members', 'update members', 'delete members', 'restore members', 'force delete members',
            'view loans', 'create loans', 'update loans', 'delete loans', 'restore loans', 'force delete loans',
            'view users', 'create users', 'update users', 'delete users',
            'manage roles',
        ];

        $permissionModels = collect($permissions)
            ->map(fn (string $permission) => Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]));

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Role::findOrCreate('Admin', 'web')->syncPermissions($permissionModels);

        $petugasPermissions = $permissionModels->whereIn('name', [
            'view books', 'create books', 'update books', 'delete books', 'restore books',
            'view categories',
            'view members', 'create members', 'update members', 'delete members', 'restore members',
            'view loans', 'create loans', 'update loans', 'delete loans', 'restore loans',
        ]);

        Role::findOrCreate('Petugas', 'web')->syncPermissions($petugasPermissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
