<?php

declare(strict_types=1);

namespace App\Brain\Queries;

use App\Models\User;
use Brain\Query;

final class GetUserById extends Query
{
    public function __construct(
        private readonly string $id,

    ) {}

    public function handle(): User
    {
        return User::query()->findOrFail($this->id);
    }
}
