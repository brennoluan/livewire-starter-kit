<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;

final class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_PERMISSIONS->value);
    }

    public function view(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_PERMISSIONS->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::CREATE_PERMISSIONS->value);
    }

    public function update(User $user): bool
    {
        return $user->can(PermissionsEnum::EDIT_PERMISSIONS->value);
    }

    public function delete(User $user): bool
    {
        return $user->can(PermissionsEnum::DELETE_PERMISSIONS->value);
    }
}
