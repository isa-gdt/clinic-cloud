<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\TaskCollection;

class GetAllTasksUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    )
    {
    }

    public function execute(): TaskCollection
    {
        return $this->taskRepository->getAll();
    }
}
