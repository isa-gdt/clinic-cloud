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

    public function getAll(int $page, int $limit): TaskCollection
    {
        $offset = ($page - 1) * $limit;
        $result = TaskModel::with(['createdBy', 'assignedTo'])
            ->skip($offset)
            ->take($limit)
            ->get();

        return TaskCollection::buildFromRaw($result->toArray());
    }

    public function getById(int $id): ?Task
    {
        $result = TaskModel::with(['createdBy', 'assignedTo'])->find($id);

        if ($result === null) {
            return null;
        }

        $createdBy = new User(
            id: $result->createdBy->id,
            name: $result->createdBy->name,
            email: $result->createdBy->email,
            password: $result->createdBy->password
        );

        $assignedTo = null;
        if ($result->assignedTo !== null) {
            $assignedTo = new User(
                id: $result->assignedTo->id,
                name: $result->assignedTo->name,
                email: $result->assignedTo->email,
                password: $result->assignedTo->password
            );
        }

        return new Task(
            id: $result->id,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: $result->text,
            status: $result->status,
            createdAt: $result->created_at->toDateTimeString(),
            updatedAt: $result->updated_at->toDateTimeString()
        );
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
        } catch (\Exception $e) {
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
        try {
            TaskModel::destroy($id);
        } catch (\Exception $e) {
            throw new PersistenceException($e->getMessage());
        }
    }

    public function updateById(int $taskId, array $data): Task
    {
        try {
            $result = tap(TaskModel::where('id', $taskId))
                ->update($data)
                ->first();
        } catch (\Exception $e) {
            throw new PersistenceException($e->getMessage());
        }

        $assignedTo = null;
        if ($result->assignedTo !== null) {
            $assignedTo = new User(
                id: $result->assignedTo->id,
                name: $result->assignedTo->name,
                email: $result->assignedTo->email,
                password: $result->assignedTo->password
            );
        }

        $createdBy = new User(
            id: $result->createdBy->id,
            name: $result->createdBy->name,
            email: $result->createdBy->email,
            password: $result->createdBy->password
        );

        return new Task(
            id: $result->id,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: $result->text,
            status: $result->status,
            createdAt: $result->created_at->toDateTimeString(),
            updatedAt: $result->updated_at->toDateTimeString(),
        );
    }
}
