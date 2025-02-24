<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain;

use PHPUnit\Framework\TestCase;
use Tests\ToDoList\Domain\MotherObject\UserMotherObject;

class UserTest extends TestCase
{
    public function testCreateUser():void
    {
        $user = UserMotherObject::buildDefault();

        $this->assertEquals(1, $user->id());
        $this->assertEquals('User', $user->name());
        $this->assertEquals('email@example.com', $user->email());
        $this->assertEquals('password', $user->password());
    }
}
