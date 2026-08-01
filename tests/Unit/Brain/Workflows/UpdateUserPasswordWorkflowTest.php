<?php

declare(strict_types=1);

use App\Brain\Workflows\UpdateUserPasswordWorkflow;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

test('UpdateUserPasswordWorkflow updates password via update method', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    test()->actingAs($user);

    $workflow = new UpdateUserPasswordWorkflow();

    $workflow->update($user, [
        'current_password' => 'password',
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);

    expect(Hash::check('new-password-123', $user->fresh()->password))->toBeTrue();
});

test('UpdateUserPasswordWorkflow validates input', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    test()->actingAs($user);

    $workflow = new UpdateUserPasswordWorkflow();

    $workflow->update($user, [
        'current_password' => 'wrong-password',
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);
})->throws(ValidationException::class);
