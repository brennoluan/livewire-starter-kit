<?php

declare(strict_types=1);

namespace App\Brain\Workflows;

use App\Brain\Actions\CreateUserEmailVerificationNotification;
use Brain\Workflow;

final class SendEmailVerificationNotificationWorkflow extends Workflow
{
    protected array $actions = [
        CreateUserEmailVerificationNotification::class,
    ];
}
