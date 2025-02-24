<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\ToDoList\Application\InputDTO\UpdateTaskInputDTO;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;

class UpdateTaskByIdUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    )
    {
    }

    public function execute(UpdateTaskInputDTO $updateTaskInputDTO): Task
    {
        $dataFromDto = [
            'assigned_to' => $updateTaskInputDTO->assignedTo() ?? null,
            'text' => $updateTaskInputDTO->text() ?? null,
            'status' => $updateTaskInputDTO->status() ?? null,
        ];

        $dataToUpdate = array_filter($dataFromDto, function ($value) {
            return $value !== null;
        });


        return $this->taskRepository->updateById($updateTaskInputDTO->id(), $dataToUpdate);

    }
}
