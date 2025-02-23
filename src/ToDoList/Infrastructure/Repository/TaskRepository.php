<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Repository;

use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\TaskCollection;
use Src\ToDoList\Infrastructure\Model\Task as TaskModel;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(): TaskCollection
    {
        $result = TaskModel::with(['createdBy', 'assignedTo'])->get();

        return TaskCollection::buildFromRaw($result->toArray());
    }
}
