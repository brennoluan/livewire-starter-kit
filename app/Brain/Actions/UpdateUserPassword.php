<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Concerns\PasswordValidationRules;
use App\Models\User;
use Brain\Action;

/**
 * @property-read User $user
 * @property-read string $password
 */
final class UpdateUserPassword extends Action
{
    use PasswordValidationRules;

    public function rules(): array
    {
        return [
            'user' => ['required'],
            'current_password' => $this->currentPasswordRules(),
            'password' => $this->passwordRules(),
        ];
    }

    public function handle(): self
    {
        $this->user->update([
            'password' => $this->password,
        ]);

        return $this;
    }
}
