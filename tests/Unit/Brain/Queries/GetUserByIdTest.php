<?php

declare(strict_types=1);

use App\Brain\Queries\GetUserById;
use App\Models\User;

test('GetUserById query returns user by id', function (): void {
    $user = User::factory()->create();

    $found = GetUserById::run(id: $user->id);

    expect($found->id)->toBe($user->id);
});
