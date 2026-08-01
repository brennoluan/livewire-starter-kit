<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

it('can register a new user', function (): void {
    $page = visit('/register');

    $page->fill('name', 'Test User')
        ->fill('email', 'test@example.com')
        ->fill('password', 'password')
        ->fill('password_confirmation', 'password')
        ->click('[data-test="register-user-button"]')
        ->assertPathIs('/email/verify')
        ->assertSee('Please verify your email address');

    assertAuthenticated();
});

it('can log in with existing user', function (): void {
    User::factory()->create([
        'email' => 'login@example.com',
    ]);

    $page = visit('/login');

    $page->fill('email', 'login@example.com')
        ->fill('password', 'password')
        ->click('[data-test="login-button"]')
        ->assertPathIs('/dashboard')
        ->assertSee('Dashboard');

    assertAuthenticated();
});

it('can see the dashboard', function (): void {
    $this->actingAs(User::factory()->create());

    visit('/dashboard')
        ->assertSee('Dashboard');
});

it('can log out', function (): void {
    $this->actingAs(User::factory()->create());

    visit('/dashboard')
        ->click('[data-test="sidebar-menu-button"]')
        ->click('button:has-text("Log out"):visible')
        ->assertPathIs('/');

    assertGuest();
});

it('cannot access dashboard without authentication', function (): void {
    visit('/dashboard')
        ->assertPathIs('/login');

    assertGuest();
});
