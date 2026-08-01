<?php

declare(strict_types=1);

use App\Brain\Workflows\DeleteUserWorkflow;
use App\Models\User;

test('DeleteUserWorkflow executes DeleteUser action', function (): void {
    $user = User::factory()->create();

    DeleteUserWorkflow::run([
        'user' => $user,
    ]);

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
