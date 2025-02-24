<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\ToDoList\Application\InputDTO\DeleteTaskInputDTO;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;

class DeleteTaskByIdUseCase
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(DeleteTaskInputDTO $dto): void
    {
        $this->taskRepository->deleteById($dto->id());
    }
}
