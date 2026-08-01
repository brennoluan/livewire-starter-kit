<?php

declare(strict_types=1);

use App\Brain\Actions\DeleteUser;
use App\Models\User;

test('DeleteUser action deletes user', function (): void {
    $user = User::factory()->create();

    DeleteUser::run([
        'user' => $user,
    ]);

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});
