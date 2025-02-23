<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain\MotherObject;

use Src\ToDoList\Domain\Task;

class TaskMotherObject
{
    public static function buildDefault(
        ?int $id = 1,
        ?string $createdBy = 'Creator',
        ?string $assignedTo = 'Assignee',
        ?string $text = 'Text',
        ?string $status = 'Status',
        ?string $createdAt = '14/12/2024',
        ?string $updatedAt = '13/01/2025'
    ): Task
    {
        return new Task(
            id: $id,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: $text,
            status: $status,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }
}
