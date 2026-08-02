<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Livewire\Roles\Create;
use App\Livewire\Roles\Delete;
use App\Livewire\Roles\Index;
use App\Livewire\Roles\Update;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
});

test('guests are redirected from roles index page', function (): void {
    $this->get(route('roles.index'))
        ->assertRedirect(route('login'));
});

test('roles index page lists roles', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);
    Role::findOrCreate('Manager', 'web');

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertSee('Manager');
});

test('can create a role via create component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('name', 'Editor')
        ->call('createRole')
        ->assertDispatched('roleCreated');

    $this->assertDatabaseHas('roles', [
        'name' => 'Editor',
    ]);
});

test('can update a role via update component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $role = Role::findOrCreate('OldRole', 'web');

    $this->actingAs($user);

    Livewire::test(Update::class, ['role' => $role])
        ->set('name', 'UpdatedRole')
        ->call('updateRole')
        ->assertDispatched('roleUpdated');

    expect($role->fresh()->name)->toBe('UpdatedRole');
});

test('can delete a role via delete component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $role = Role::findOrCreate('RoleToDelete', 'web');

    $this->actingAs($user);

    Livewire::test(Delete::class, ['role' => $role])
        ->call('deleteRole')
        ->assertDispatched('roleDeleted');

    $this->assertDatabaseMissing('roles', [
        'id' => $role->id,
    ]);
});
