<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\Role;
use Brain\Action;

/**
 * @property-read string $name
 * @property-read array<int, string>|null $permissions
 * @property Role|null $role
 */
final class CreateRole extends Action
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
        ];
    }

    public function handle(): self
    {
        /** @var Role $role */
        $role = Role::query()->create([
            'name' => $this->name,
            'guard_name' => 'web',
        ]);

        $this->role = $role;

        if (is_array($this->permissions)) {
            $this->role->syncPermissions($this->permissions);
        }

        return $this;
    }
}
