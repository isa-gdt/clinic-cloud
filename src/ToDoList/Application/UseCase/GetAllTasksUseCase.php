<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\ToDoList\Application\InputDTO\GetAllTasksInputDTO;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\TaskCollection;

class GetAllTasksUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    )
    {
    }

    public function execute(GetAllTasksInputDTO $dto): TaskCollection
    {
        return $this->taskRepository->getAll($dto->page(), $dto->limit());
    }
}
