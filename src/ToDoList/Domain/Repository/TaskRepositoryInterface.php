<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain\Repository;

use Src\ToDoList\Domain\Task;
use Src\ToDoList\Domain\TaskCollection;

interface TaskRepositoryInterface
{
    public function getAll(int $page, int $limit): TaskCollection;

    public function getById(int $id): ?Task;

    public function save(Task $task): Task;

    public function deleteById(int $id): void;

    public function updateById(int $taskId, array $data): Task;
}
