<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\Role;
use Brain\Action;

/**
 * @property-read Role $role
 */
final class DeleteRole extends Action
{
    public function handle(): self
    {
        $this->role->delete();

        return $this;
    }

    public function rules(): array
    {
        return [
            'role' => ['required'],
        ];
    }
}
