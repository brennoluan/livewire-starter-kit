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
final class CreateUserPassword extends Action
{
    use PasswordValidationRules;

    public function rules(): array
    {
        return [
            'user' => ['required'],
            'password' => $this->passwordRules(),
        ];
    }

    public function handle(): self
    {
        $this->user->forceFill([
            'password' => $this->password,
        ])->save();

        return $this;
    }
}
