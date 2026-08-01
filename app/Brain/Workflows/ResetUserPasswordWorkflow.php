<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\CreateUserPassword;
use App\Models\User;
use Brain\Workflow;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

final class ResetUserPasswordWorkflow extends Workflow implements ResetsUserPasswords
{
    protected array $actions = [
        CreateUserPassword::class,
    ];

    /**
     * @param  array<string, mixed>  $input
     */
    public function reset(User $user, array $input): void
    {
        self::run([
            'user' => $user,
            'password' => $input['password'] ?? null,
            'password_confirmation' => $input['password_confirmation'] ?? null,
        ]);
    }
}
