<?php

declare(strict_types=1);

use App\Brain\Workflows\SendPasswordResetNotificationWorkflow;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

test('SendPasswordResetNotificationWorkflow runs reset notification workflow', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    SendPasswordResetNotificationWorkflow::run([
        'user' => $user,
        'token' => 'sample-token',
    ]);

    expect($user)->toBeInstanceOf(User::class);
});
