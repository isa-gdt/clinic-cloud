<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain\MotherObject;

use Src\Auth\Domain\User;

class UserMotherObject
{
    public static function buildDefault(
        ?int $id = 1,
        ?string $name = 'User',
        ?string $email = 'email@example.com',
        ?string $password = 'password',
    ): User
    {
        return new User($id, $name, $email, $password);
    }
}
