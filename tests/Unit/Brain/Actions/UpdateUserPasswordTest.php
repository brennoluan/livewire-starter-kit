<?php

declare(strict_types=1);

use App\Brain\Actions\UpdateUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('UpdateUserPassword action updates password via run', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    test()->actingAs($user);

    UpdateUserPassword::run([
        'user' => $user,
        'current_password' => 'password',
        'password' => 'action-password-123',
        'password_confirmation' => 'action-password-123',
    ]);

    expect(Hash::check('action-password-123', $user->fresh()->password))->toBeTrue();
});
