<?php

declare(strict_types=1);

use App\Brain\Workflows\ResetUserPasswordWorkflow;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

test('ResetUserPasswordWorkflow resets password via reset method', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $workflow = new ResetUserPasswordWorkflow();

    $workflow->reset($user, [
        'password' => 'new-reset-password-123',
        'password_confirmation' => 'new-reset-password-123',
    ]);

    expect(Hash::check('new-reset-password-123', $user->fresh()->password))->toBeTrue();
});

test('ResetUserPasswordWorkflow validates input', function (): void {
    $user = User::factory()->create();

    $workflow = new ResetUserPasswordWorkflow();

    $workflow->reset($user, [
        'password' => 'new-reset-password-123',
        'password_confirmation' => 'mismatch',
    ]);
})->throws(ValidationException::class);
