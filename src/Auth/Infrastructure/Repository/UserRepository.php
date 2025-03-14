<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Repository;

use Src\Auth\Domain\Repository\UserRepositoryInterface;
use Src\Auth\Domain\User;
use Src\Auth\Infrastructure\Model\User as UserModel;

class UserRepository implements UserRepositoryInterface
{
    public function getUserById(int $id): ?User
    {
        $result = UserModel::find($id);

        if(!$result){
            return null;
        }

        return new User(
            id: $result->id,
            name: $result->name,
            email: $result->email,
            password: $result->password
        );
    }
}
