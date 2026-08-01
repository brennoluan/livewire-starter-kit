<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\User;
use Brain\Action;

/**
 * @property-read User $user
 * @property-read string $token
 */
final class CreateUserEmailResetNotification extends Action
{
    public function rules(): array
    {
        return [
            'user' => ['required'],
            'token' => ['required', 'string'],
        ];
    }

    public function handle(): self
    {
        $this->user->sendPasswordResetNotification($this->token);

        return $this;
    }
}
