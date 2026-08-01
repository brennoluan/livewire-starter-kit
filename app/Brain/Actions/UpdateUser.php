<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Brain\Action;
use Illuminate\Validation\Rule;

/**
 * @property-read User $user
 * @property-read string $name
 * @property-read string $email
 */
final class UpdateUser extends Action
{
    use ProfileValidationRules;

    public function rules(): array
    {
        $user = $this->payload->user ?? null;
        $userId = $user instanceof User ? $user->id : null;

        return [
            'user' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ],
        ];
    }

    public function handle(): self
    {
        $this->user->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->user->isDirty('email')) {
            $this->user->email_verified_at = null;
        }

        $this->user->save();

        return $this;
    }
}
