<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\DeletePermission;
use Brain\Workflow;

final class DeletePermissionWorkflow extends Workflow
{
    protected array $actions = [
        DeletePermission::class,
    ];
}
