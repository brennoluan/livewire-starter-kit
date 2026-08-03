<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;
use Laravel\Head\Facades\Head;

beforeEach(function (): void {
    Role::findOrCreate(RolesEnum::SUPER_ADMIN->value, 'web');
});

test('welcome page renders correct head tags managed by laravel head', function (): void {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('<title>Welcome - Laravel</title>', false)
        ->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1.0">', false)
        ->assertSee('<meta property="og:site_name" content="Laravel">', false)
        ->assertSee('<link rel="icon" href="/favicon.svg" type="image/svg+xml">', false)
        ->assertSee('<link rel="canonical"', false);
});

test('authenticated routes render route defined titles via laravel head', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPER_ADMIN->value);
    $this->actingAs($user);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('<title>Dashboard - Laravel</title>', false);

    $this->get(route('users.index'))
        ->assertOk()
        ->assertSee('<title>Users - Laravel</title>', false);

    $this->get(route('roles.index'))
        ->assertOk()
        ->assertSee('<title>Roles - Laravel</title>', false);

    $this->get(route('permissions.index'))
        ->assertOk()
        ->assertSee('<title>Permissions - Laravel</title>', false);

    $this->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('<title>Profile settings - Laravel</title>', false);
});

test('error metadata is configured for error status codes', function (): void {
    Head::status(404);
    $array = Head::toArray();

    expect($array['title'])->toBe('Page Not Found - Laravel')
        ->and($array['description'])->toBe('The page you are looking for could not be found.')
        ->and($array['robots'])->toBe('noindex, follow');
});
