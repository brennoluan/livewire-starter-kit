<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;

final class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_USERS->value);
    }

    public function view(User $user): bool
    {
        return $user->can(PermissionsEnum::VIEW_USERS->value);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionsEnum::CREATE_USERS->value);
    }

    public function update(User $user): bool
    {
        return $user->can(PermissionsEnum::EDIT_USERS->value);
    }

    public function delete(User $user, User $model): bool
    {
        // Prevent user from deleting themselves via policy
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can(PermissionsEnum::DELETE_USERS->value);
    }
}
