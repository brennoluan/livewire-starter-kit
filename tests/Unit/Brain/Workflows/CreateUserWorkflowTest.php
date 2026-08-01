<?php

declare(strict_types=1);

use App\Brain\Workflows\CreateUserWorkflow;
use App\Models\User;
use Illuminate\Validation\ValidationException;

test('CreateUserWorkflow creates user via create method', function (): void {
    $workflow = new CreateUserWorkflow();

    $user = $workflow->create([
        'name' => 'Workflow User',
        'email' => 'workflowuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('Workflow User');
});

test('CreateUserWorkflow validates input', function (): void {
    $workflow = new CreateUserWorkflow();

    $workflow->create([
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);
})->throws(ValidationException::class);
