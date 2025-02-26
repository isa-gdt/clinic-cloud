<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain;

use Src\Auth\Domain\User;
use Src\Common\Domain\Collection;

class TaskCollection extends Collection
{
    public static function buildFromRaw(array $rawTasks): TaskCollection
    {
        $tasks = [];
        foreach ($rawTasks as $task) {
            $createdBy = new User(
                id: $task['created_by']['id'],
                name: $task['created_by']['name'],
                email: $task['created_by']['email'],
                password: $task['created_by']['password'],
            );

            $assignedTo = null;
            if ($task['assigned_to'] !== null) {
                $assignedTo = new User(
                    id: $task['assigned_to']['id'],
                    name: $task['assigned_to']['name'],
                    email: $task['assigned_to']['email'],
                    password: $task['assigned_to']['password'],
                );
            }

            $tasks[] = new Task(
                id: $task['id'],
                createdBy: $createdBy,
                assignedTo: $assignedTo,
                text: $task['text'],
                status: $task['status'],
                createdAt: $task['created_at'],
                updatedAt: $task['updated_at'],
            );
        }
        return new self($tasks);
    }
}
