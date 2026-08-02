<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
});

it('redirects guests from users page to login', function (): void {
    visit('/users')
        ->assertPathIs('/login');
});

it('shows 403 for users without permission on users page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/users')
        ->assertSee('403');

});

it('renders the users index page for super admin', function (): void {
    $superAdmin = User::factory()->create();
    $superAdmin->assignRole(RolesEnum::SUPER_ADMIN->value);

    $this->actingAs($superAdmin);

    visit('/users')
        ->assertSee('Users')
        ->assertSee('List, create, update and delete users')
        ->assertSee($superAdmin->name);
});
