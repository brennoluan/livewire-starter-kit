<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

final class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        // Create all permissions
        foreach (PermissionsEnum::cases() as $permission) {
            Permission::findOrCreate($permission->value, 'web');
        }

        // Create Super Admin role
        $superAdmin = Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
        $superAdmin->syncPermissions(Permission::all());

        // Create Admin role
        $admin = Role::findOrCreate(RolesEnum::ADMIN->value, 'web');
        $admin->syncPermissions([
            PermissionsEnum::VIEW_USERS->value,
            PermissionsEnum::CREATE_USERS->value,
            PermissionsEnum::EDIT_USERS->value,
            PermissionsEnum::VIEW_ROLES->value,
            PermissionsEnum::VIEW_PERMISSIONS->value,
        ]);

        // Create User role
        Role::findOrCreate(RolesEnum::USER->value, 'web');
    }
}
