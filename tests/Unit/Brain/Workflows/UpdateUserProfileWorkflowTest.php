<?php

declare(strict_types=1);

use App\Brain\Workflows\UpdateUserProfileWorkflow;
use App\Models\User;
use Illuminate\Validation\ValidationException;

test('UpdateUserProfileWorkflow updates profile via update method', function (): void {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $workflow = new UpdateUserProfileWorkflow();

    $workflow->update($user, [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    expect($user->fresh()->name)->toBe('Updated Name')
        ->and($user->fresh()->email)->toBe('updated@example.com');
});

test('UpdateUserProfileWorkflow validates input', function (): void {
    $user = User::factory()->create();

    $workflow = new UpdateUserProfileWorkflow();

    $workflow->update($user, [
        'name' => 'Updated Name',
        'email' => 'invalid-email',
    ]);
})->throws(ValidationException::class);
