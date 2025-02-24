<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain;

use PHPUnit\Framework\TestCase;
use Tests\Auth\MotherObject\UserMotherObject;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class TaskTest extends TestCase
{
    public function testCreateTask(): void
    {
        $task = TaskMotherObject::buildDefault();

        $this->assertEquals(1,$task->id());
        $this->assertEquals(UserMotherObject::buildDefault(), $task->createdBy());
        $this->assertEquals(UserMotherObject::buildDefault(), $task->assignedTo());
        $this->assertEquals('Status', $task->status());
        $this->assertEquals('14/12/2024', $task->createdAt());
        $this->assertEquals('13/01/2025', $task->updatedAt());
    }
}
