<?php

declare(strict_types=1);

use App\Brain\Actions\CreateUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('CreateUserPassword action resets password via run', function (): void {
    $user = User::factory()->create();

    CreateUserPassword::run([
        'user' => $user,
        'password' => 'reset-password-123',
        'password_confirmation' => 'reset-password-123',
    ]);

    expect(Hash::check('reset-password-123', $user->fresh()->password))->toBeTrue();
});
