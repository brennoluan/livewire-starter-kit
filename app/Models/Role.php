<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\WithoutIncrementing;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

#[WithoutIncrementing]
final class Role extends SpatieRole
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasUuids;

    protected $keyType = 'string';
}
