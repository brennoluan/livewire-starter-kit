<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\Permission;
use Brain\Action;

/**
 * @property-read string $name
 * @property Permission|null $permission
 */
final class CreatePermission extends Action
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ];
    }

    public function handle(): self
    {
        /** @var Permission $permission */
        $permission = Permission::query()->create([
            'name' => $this->name,
            'guard_name' => 'web',
        ]);

        $this->permission = $permission;

        return $this;
    }
}
