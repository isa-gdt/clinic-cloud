<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain\Repository;

use Src\ToDoList\Domain\Task;
use Src\ToDoList\Domain\TaskCollection;

interface TaskRepositoryInterface
{
    public function getAll(): TaskCollection;

    public function save(Task $task): Task;

    public function deleteById(int $id): void;

    public function updateById(int $id, array $data): Task;
}
