<?php

declare(strict_types=1);

namespace App\Brain\Actions;

use App\Models\Permission;
use Brain\Action;

/**
 * @property-read Permission $permission
 */
final class DeletePermission extends Action
{
    public function handle(): self
    {
        $this->permission->delete();

        return $this;
    }

    public function rules(): array
    {
        return [
            'permission' => ['required'],
        ];
    }
}
