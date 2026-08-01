<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Brain\Action;

/**
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 * @property User|null $user
 */
final class CreateUser extends Action
{
    use PasswordValidationRules;
    use ProfileValidationRules;

    public function rules(): array
    {
        return [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ];
    }

    public function handle(): self
    {
        $this->user = User::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        return $this;
    }
}
