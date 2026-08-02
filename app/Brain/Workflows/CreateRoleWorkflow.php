<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\CreateRole;
use Brain\Workflow;

final class CreateRoleWorkflow extends Workflow
{
    protected array $actions = [
        CreateRole::class,
    ];
}
