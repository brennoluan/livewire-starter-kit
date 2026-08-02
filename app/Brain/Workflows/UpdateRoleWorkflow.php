<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\UpdateRole;
use Brain\Workflow;

final class UpdateRoleWorkflow extends Workflow
{
    protected array $actions = [
        UpdateRole::class,
    ];
}
