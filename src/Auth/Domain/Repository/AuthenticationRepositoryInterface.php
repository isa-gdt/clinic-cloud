<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Repository;

use Src\Auth\Domain\User;

interface AuthenticationRepositoryInterface
{
    public function getUserById(int $id): ?User;
    public function getUserByEmail(string $email): ?User;
}
