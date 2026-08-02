<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\Permission;
use Brain\Action;
use Illuminate\Validation\Rule;

/**
 * @property-read Permission $permission
 * @property-read string $name
 */
final class UpdatePermission extends Action
{
    public function rules(): array
    {
        $permission = $this->payload->permission ?? null;
        $permissionId = $permission instanceof Permission ? $permission->id : null;

        return [
            'permission' => ['required'],
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permissionId)],
        ];
    }

    public function handle(): self
    {
        $this->permission->update([
            'name' => $this->name,
        ]);

        return $this;
    }
}
