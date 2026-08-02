<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\WithoutIncrementing;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

#[WithoutIncrementing]
final class Permission extends SpatiePermission
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasUuids;

    protected $keyType = 'string';
}
