<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Repository;

use Src\Auth\Domain\User;
use Src\Common\Infrastructure\Exception\PersistenceException;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;
use Src\ToDoList\Domain\TaskCollection;
use Src\ToDoList\Infrastructure\Model\Task as TaskModel;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(): TaskCollection
    {
        $result = TaskModel::with(['createdBy', 'assignedTo'])->get();

        return TaskCollection::buildFromRaw($result->toArray());
    }

    public function save(Task $task): Task
    {
        try {
            $result = TaskModel::create(
                [
                    'created_by' => $task->createdBy()->id(),
                    'assigned_to' => $task->assignedTo()?->id(),
                    'text' => $task->text(),
                    'status' => $task->status(),
                ]
            );
        } catch(\Exception $e) {
            throw new PersistenceException($e->getMessage());
        }

        $assignedTo = null;
        if ($task->assignedTo() !== null) {
            $assignedTo = new User(
                id: $result->assignedTo->id,
                name: $result->assignedTo->name,
                email: $result->assignedTo->email,
                password: $result->assignedTo->password
            );
        }

        return new Task(
            id: $result->id,
            createdBy: $task->createdBy(),
            assignedTo: $assignedTo,
            text: $result->text,
            status: $result->status,
            createdAt: $result->created_at->toDateTimeString(),
            updatedAt: $result->created_at->toDateTimeString(),
        );
    }

    public function deleteById(int $id): void
    {
        try{
            TaskModel::destroy($id);
        } catch (\Exception $e)
        {
            throw new PersistenceException($e->getMessage());
        }
    }

    public function updateById(int $id, array $data): Task
    {
        try {
            $task = TaskModel::with(['createdBy', 'assignedTo'])->find($id);
            $task->update($data);
        } catch (\Exception $e)
        {
            throw new PersistenceException($e->getMessage());
        }

        $assignedTo = null;
        if ($task->assignedTo() !== null) {
            $assignedTo = new User(
                id: $task->assignedTo->id,
                name: $task->assignedTo->name,
                email: $task->assignedTo->email,
                password: $task->assignedTo->password
            );
        }

        $createdBy = new User(
            id: $task->createdBy->id,
            name: $task->createdBy->name,
            email: $task->createdBy->email,
            password: $task->createdBy->password
        );

        return new Task(
            id: $task->id,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: $task->text,
            status: $task->status,
            createdAt: $task->created_at->toDateTimeString(),
            updatedAt: $task->created_at->toDateTimeString(),
        );
    }
}
