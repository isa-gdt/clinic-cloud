<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Transformer;

use Src\ToDoList\Domain\Task;

class TaskTransformer
{
    public function transform(Task $task): array
    {
        return [
            'id' => $task->id(),
            'created_by' => $task->createdBy()->name(),
            'assigned_to' => $task->assignedTo()?->name(),
            'text' => $task->text(),
            'status' => $task->status(),
            'created_at' => $task->createdAt(),
            'updated_at' => $task->updatedAt(),
        ];
    }
}
