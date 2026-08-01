<?php

declare(strict_types=1);

use App\Brain\Queries\GetUserByEmail;
use App\Models\User;

test('GetUserByEmail query returns user by email', function (): void {
    $user = User::factory()->create(['email' => 'queryuser@example.com']);

    $found = GetUserByEmail::run(email: 'queryuser@example.com');

    expect($found)->not->toBeNull()
        ->and($found->id)->toBe($user->id);
});
