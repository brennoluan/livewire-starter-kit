<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\DeleteUser;
use Brain\Workflow;

final class DeleteUserWorkflow extends Workflow
{
    protected array $actions = [
        DeleteUser::class,
    ];
}
