<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\CreateUser;
use App\Models\User;
use Brain\Workflow;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use RuntimeException;

final class CreateUserWorkflow extends Workflow implements CreatesNewUsers
{
    protected array $actions = [
        CreateUser::class,
    ];

    /**
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        $result = self::run($input);

        throw_if(! is_object($result) || ! isset($result->user) || ! $result->user instanceof User, RuntimeException::class, 'Failed to create user.');

        return $result->user;
    }
}
