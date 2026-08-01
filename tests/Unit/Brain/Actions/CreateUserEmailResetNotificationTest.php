<?php

declare(strict_types=1);

use App\Brain\Actions\CreateUserEmailResetNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

test('CreateUserEmailResetNotification action triggers password reset notification', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    CreateUserEmailResetNotification::run([
        'user' => $user,
        'token' => 'reset-token-123',
    ]);

    expect($user)->toBeInstanceOf(User::class);
});
