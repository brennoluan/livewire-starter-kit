<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\UpdateUserPassword;
use App\Models\User;
use Brain\Workflow;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

final class UpdateUserPasswordWorkflow extends Workflow implements UpdatesUserPasswords
{
    protected array $actions = [
        UpdateUserPassword::class,
    ];

    /**
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        self::run([
            'user' => $user,
            'current_password' => $input['current_password'] ?? null,
            'password' => $input['password'] ?? null,
            'password_confirmation' => $input['password_confirmation'] ?? null,
        ]);
    }
}
