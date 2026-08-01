<?php

declare(strict_types=1);

use App\Brain\Actions\UpdateUser;
use App\Models\User;

test('UpdateUser action updates user profile via run', function (): void {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    UpdateUser::run([
        'user' => $user,
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);

    expect($user->fresh()->name)->toBe('New Name')
        ->and($user->fresh()->email)->toBe('new@example.com');
});
