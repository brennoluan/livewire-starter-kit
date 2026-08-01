<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\User;
use Brain\Action;

/**
 * @property-read User $user
 */
final class CreateUserEmailVerificationNotification extends Action
{
    public function rules(): array
    {
        return [
            'user' => ['required'],
        ];
    }

    public function handle(): self
    {
        $this->user->sendEmailVerificationNotification();

        return $this;
    }
}
