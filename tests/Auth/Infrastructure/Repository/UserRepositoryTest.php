<?php

declare(strict_types=1);

namespace Tests\Auth\Infrastructure\Repository;

use Src\Auth\Domain\User;
use Src\Auth\Infrastructure\Repository\UserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testGetUserById(): void
    {
        // Given
        $repository = new UserRepository();

        //When
        $user = $repository->getUserById(99);

        //Then
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(99, $user->id());
        $this->assertEquals('Chandler Bing', $user->name());
        $this->assertEquals('chandler@friends.com', $user->email());
        $this->assertEquals(
            '$2y$12$d47xFAzzYpXT.r/1AW308usriBMUkRfAiH4rHzPSST/KSzHUfE5Xi',
            $user->password()
        );
    }

    public function testGetUserByIdReturnsNull(): void
    {
        //Given
        $repository = new UserRepository();

        //When
        $user = $repository->getUserById(0);

        //Then
        $this->assertNull($user);
    }
}
