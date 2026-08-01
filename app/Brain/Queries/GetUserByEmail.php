<?php

declare(strict_types=1);

namespace App\Brain\Queries;

use App\Models\User;
use Brain\Query;

final class GetUserByEmail extends Query
{
    public function __construct(
        private readonly string $email,
    ) {}

    public function handle(): ?User
    {
        return User::query()->where('email', $this->email)->first();
    }
}
