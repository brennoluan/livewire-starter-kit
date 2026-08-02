<?php

declare(strict_types=1);

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
    Permission::findOrCreate(PermissionsEnum::VIEW_PERMISSIONS->value, 'web');
});

it('redirects guests from permissions page to login', function (): void {
    visit('/permissions')
        ->assertPathIs('/login');
});

it('shows 403 for users without permission on permissions page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/permissions')
        ->assertSee('403');

});

it('renders the permissions index page for super admin', function (): void {
    $superAdmin = User::factory()->create();
    $superAdmin->assignRole(RolesEnum::SUPER_ADMIN->value);

    $this->actingAs($superAdmin);

    visit('/permissions')
        ->assertSee('Permissions')
        ->assertSee('Manage system permissions')
        ->assertSee(PermissionsEnum::VIEW_PERMISSIONS->value);
});
