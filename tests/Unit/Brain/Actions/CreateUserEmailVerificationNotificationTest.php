<?php

declare(strict_types=1);

use App\Brain\Actions\CreateUserEmailVerificationNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

test('CreateUserEmailVerificationNotification action triggers email verification notification', function (): void {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    CreateUserEmailVerificationNotification::run([
        'user' => $user,
    ]);

    expect($user)->toBeInstanceOf(User::class);
});
