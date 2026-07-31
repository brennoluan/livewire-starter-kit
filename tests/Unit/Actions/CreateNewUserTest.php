<?php

declare(strict_types=1);

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;

test('create new user action creates user successfully', function (): void {
    $action = new CreateNewUser();

    $user = $action->create([
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('New User')
        ->and($user->email)->toBe('newuser@example.com');
});

test('create new user action throws validation exception on invalid input', function (): void {
    $action = new CreateNewUser();

    $action->create([
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);
})->throws(ValidationException::class);
