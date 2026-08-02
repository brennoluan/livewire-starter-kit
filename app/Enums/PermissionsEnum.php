<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionsEnum: string
{
    case VIEW_USERS = 'view users';
    case CREATE_USERS = 'create users';
    case EDIT_USERS = 'edit users';
    case DELETE_USERS = 'delete users';

    case VIEW_ROLES = 'view roles';
    case CREATE_ROLES = 'create roles';
    case EDIT_ROLES = 'edit roles';
    case DELETE_ROLES = 'delete roles';

    case VIEW_PERMISSIONS = 'view permissions';
    case CREATE_PERMISSIONS = 'create permissions';
    case EDIT_PERMISSIONS = 'edit permissions';
    case DELETE_PERMISSIONS = 'delete permissions';
}
