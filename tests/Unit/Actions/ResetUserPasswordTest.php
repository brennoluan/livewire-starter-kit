<?php

declare(strict_types=1);

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

test('reset user password action updates password', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $action = new ResetUserPassword();

    $action->reset($user, [
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);

    expect(Hash::check('new-password-123', $user->fresh()->password))->toBeTrue();
});

test('reset user password action validates password confirmation', function (): void {
    $user = User::factory()->create();

    $action = new ResetUserPassword();

    $action->reset($user, [
        'password' => 'new-password-123',
        'password_confirmation' => 'wrong-confirmation',
    ]);
})->throws(ValidationException::class);
