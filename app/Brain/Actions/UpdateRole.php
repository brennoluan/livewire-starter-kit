<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\Role;
use Brain\Action;
use Illuminate\Validation\Rule;

/**
 * @property-read Role $role
 * @property-read string $name
 * @property-read array<int, string>|null $permissions
 */
final class UpdateRole extends Action
{
    public function rules(): array
    {
        $role = $this->payload->role ?? null;
        $roleId = $role instanceof Role ? $role->id : null;

        return [
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($roleId)],
            'permissions' => ['nullable', 'array'],
        ];
    }

    public function handle(): self
    {
        $this->role->update([
            'name' => $this->name,
        ]);

        if (is_array($this->permissions)) {
            $this->role->syncPermissions($this->permissions);
        }

        return $this;
    }
}
