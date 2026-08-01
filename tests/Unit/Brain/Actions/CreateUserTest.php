<?php

declare(strict_types=1);

use App\Brain\Actions\CreateUser;
use App\Models\User;

test('CreateUser action creates a user record via run', function (): void {
    $result = CreateUser::run([
        'name' => 'Brain User',
        'email' => 'createuser@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    expect($result->user)->toBeInstanceOf(User::class)
        ->and($result->user->name)->toBe('Brain User')
        ->and($result->user->email)->toBe('createuser@example.com');
});
