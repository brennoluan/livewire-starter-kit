<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\CreatePermission;
use Brain\Workflow;

final class CreatePermissionWorkflow extends Workflow
{
    protected array $actions = [
        CreatePermission::class,
    ];
}
