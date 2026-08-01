<?php

declare(strict_types=1);

use App\Models\User;

it('shows the dashboard page for authenticated users', function (): void {
    $this->actingAs(User::factory()->create());

    visit('/dashboard')
        ->assertSee('Dashboard');
});

it('redirects guests to the login page when accessing the dashboard', function (): void {
    visit('/dashboard')
        ->assertPathIs('/login');
});
