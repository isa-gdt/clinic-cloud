<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Repository;

use Src\Auth\Domain\Repository\AuthenticationRepositoryInterface;
use Src\Auth\Domain\User;
use Src\Auth\Infrastructure\Models\User as UserModel;

class AuthenticationRepository implements AuthenticationRepositoryInterface
{
    public function getUserById(int $id): ?User
    {
        $result = UserModel::find($id);

        return new User(
            id: $result->id,
            name: $result->name,
            email: $result->email,
            password: $result->password
        );
    }

    public function getUserByEmail(string $email): ?User
    {
       /* $result = UserModel::where('email', $email)->first();

        if (!$result) {
            return null;
        }

        $user = User::createFromModel($result);
        $result->createToken($user->name.'-AuthToken')->plainTextToken;*/
        //return $user;
    }
}
