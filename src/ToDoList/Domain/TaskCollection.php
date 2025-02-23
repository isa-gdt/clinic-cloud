<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain;

use Src\Common\Domain\Collection;

class TaskCollection extends Collection
{
    public static function buildFromRaw(array $rawTasks): TaskCollection
    {

        $tasks = [];
        foreach ($rawTasks as $task) {
            $tasks[] = new Task(
                id: $task['id'],
                createdBy: $task['created_by']['name'],
                assignedTo: $task['assigned_to'] ? $task['assigned_to']['name'] : null,
                text: $task['text'],
                status: $task['status'],
                createdAt: $task['created_at'],
                updatedAt: $task['updated_at'],
            );
        }

        return new self($tasks);
    }
}
