<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\DeleteRole;
use Brain\Workflow;

final class DeleteRoleWorkflow extends Workflow
{
    protected array $actions = [
        DeleteRole::class,
    ];
}
