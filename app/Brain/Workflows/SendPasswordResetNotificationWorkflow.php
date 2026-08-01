<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\CreateUserEmailResetNotification;
use Brain\Workflow;

final class SendPasswordResetNotificationWorkflow extends Workflow
{
    protected array $actions = [
        CreateUserEmailResetNotification::class,
    ];
}
