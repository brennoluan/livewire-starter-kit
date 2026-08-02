<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Livewire\Users\Create;
use App\Livewire\Users\Delete;
use App\Livewire\Users\Index;
use App\Livewire\Users\Update;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
});

test('guests are redirected from users index page', function (): void {
    $this->get(route('users.index'))
        ->assertRedirect(route('login'));
});

test('users index page lists users including the authenticated user', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $otherUser = User::factory()->create(['name' => 'Specific Other User']);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertSee('Specific Other User')
        ->assertSee($user->email);
});

test('can create a user via create component', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('name', 'John Doe')
        ->set('email', 'john.doe@example.com')
        ->set('password', 'password123')
        ->call('createUser')
        ->assertDispatched('userCreated');

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);
});

test('can update a user via update component', function (): void {
    $authUser = User::factory()->create();
    $authUser->assignRole(RolesEnum::SUPER_ADMIN->value);

    $targetUser = User::factory()->create(['name' => 'Old Name']);

    $this->actingAs($authUser);

    Livewire::test(Update::class, ['user' => $targetUser])
        ->set('name', 'New Name')
        ->set('email', $targetUser->email)
        ->call('updateUser')
        ->assertDispatched('userUpdated');

    expect($targetUser->fresh()->name)->toBe('New Name');
});

test('can delete a user via delete component', function (): void {
    $authUser = User::factory()->create();
    $authUser->assignRole(RolesEnum::SUPER_ADMIN->value);

    $targetUser = User::factory()->create();

    $this->actingAs($authUser);

    Livewire::test(Delete::class, ['user' => $targetUser])
        ->call('deleteUser')
        ->assertDispatched('userDeleted');

    $this->assertDatabaseMissing('users', [
        'id' => $targetUser->id,
    ]);
});
