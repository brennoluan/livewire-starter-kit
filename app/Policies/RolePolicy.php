<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Role;
use App\Models\User;

final class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_ROLES->value);
    }

    public function view(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_ROLES->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::CREATE_ROLES->value);
    }

    public function update(User $user): bool
    {
        return $user->can(PermissionsEnum::EDIT_ROLES->value);
    }

    public function delete(User $user, Role $role): bool
    {
        // Prevent deleting Super Admin role
        if ($role->name === 'Super Admin') {
            return false;
        }

        return $user->can(PermissionsEnum::DELETE_ROLES->value);
    }
}
