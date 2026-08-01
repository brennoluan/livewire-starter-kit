<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\UpdateUser;
use App\Models\User;
use Brain\Workflow;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

final class UpdateUserProfileWorkflow extends Workflow implements UpdatesUserProfileInformation
{
    protected array $actions = [
        UpdateUser::class,
    ];

    /**
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        self::run([
            'user' => $user,
            'name' => $input['name'] ?? null,
            'email' => $input['email'] ?? null,
        ]);
    }
}
