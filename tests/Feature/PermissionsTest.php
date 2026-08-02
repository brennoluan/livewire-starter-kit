<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Livewire\Permissions\Create;
use App\Livewire\Permissions\Delete;
use App\Livewire\Permissions\Index;
use App\Livewire\Permissions\Update;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
});

test('guests are redirected from permissions index page', function (): void {
    $this->get(route('permissions.index'))
        ->assertRedirect(route('login'));
});

test('permissions index page lists permissions', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);
    Permission::findOrCreate('publish articles', 'web');

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertSee('publish articles');
});

test('can create a permission via create component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('name', 'export reports')
        ->call('createPermission')
        ->assertDispatched('permissionCreated');

    $this->assertDatabaseHas('permissions', [
        'name' => 'export reports',
    ]);
});

test('can update a permission via update component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $permission = Permission::findOrCreate('old permission', 'web');

    $this->actingAs($user);

    Livewire::test(Update::class, ['permission' => $permission])
        ->set('name', 'updated permission')
        ->call('updatePermission')
        ->assertDispatched('permissionUpdated');

    expect($permission->fresh()->name)->toBe('updated permission');
});

test('can delete a permission via delete component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $permission = Permission::findOrCreate('permission to delete', 'web');

    $this->actingAs($user);

    Livewire::test(Delete::class, ['permission' => $permission])
        ->call('deletePermission')
        ->assertDispatched('permissionDeleted');

    $this->assertDatabaseMissing('permissions', [
        'id' => $permission->id,
    ]);
});
