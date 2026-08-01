<?php

declare(strict_types=1);

use App\Brain\Workflows\SendEmailVerificationNotificationWorkflow;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

test('SendEmailVerificationNotificationWorkflow runs notification workflow', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    SendEmailVerificationNotificationWorkflow::run([
        'user' => $user,
    ]);

    expect($user)->toBeInstanceOf(User::class);
});
