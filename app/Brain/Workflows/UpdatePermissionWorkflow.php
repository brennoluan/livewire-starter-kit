<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\UpdatePermission;
use Brain\Workflow;

final class UpdatePermissionWorkflow extends Workflow
{
    protected array $actions = [
        UpdatePermission::class,
    ];
}
