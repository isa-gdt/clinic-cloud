<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain\MotherObject;

use Src\Auth\Domain\User;
use Src\ToDoList\Domain\Task;
use Tests\Auth\MotherObject\UserMotherObject;

class TaskMotherObject
{
    public static function buildDefault(
        ?int $id = 1,
        ?User $createdBy = null,
        ?User $assignedTo = null,
        ?string $text = 'Text',
        ?string $status = 'Status',
        ?string $createdAt = '14/12/2024',
        ?string $updatedAt = '13/01/2025'
    ): Task
    {
        return new Task(
            id: $id,
            createdBy: $createdBy ?? UserMotherObject::buildDefault(),
            assignedTo: $assignedTo ?? UserMotherObject::buildDefault(),
            text: $text,
            status: $status,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }
}
