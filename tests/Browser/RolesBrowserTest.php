<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
});

it('redirects guests from roles page to login', function (): void {
    visit('/roles')
        ->assertPathIs('/login');
});

it('shows 403 for users without permission on roles page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/roles')
        ->assertSee('403');

});

it('renders the roles index page for super admin', function (): void {
    $superAdmin = User::factory()->create();
    $superAdmin->assignRole(RolesEnum::SUPER_ADMIN->value);

    $this->actingAs($superAdmin);

    visit('/roles')
        ->assertSee('Roles')
        ->assertSee('Manage system roles and permissions')
        ->assertSee(RolesEnum::SUPER_ADMIN->value);
});
