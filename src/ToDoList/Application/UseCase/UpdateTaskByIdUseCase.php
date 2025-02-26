<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\Auth\Domain\Repository\AuthenticationRepositoryInterface;
use Src\ToDoList\Application\InputDTO\UpdateTaskInputDTO;
use Src\ToDoList\Domain\Exception\TaskNotFoundException;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;

class UpdateTaskByIdUseCase
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly AuthenticationRepositoryInterface $authenticationRepository,
    )
    {
    }

    public function execute(UpdateTaskInputDTO $updateTaskInputDTO): Task
    {
        $task = $this->taskRepository->getById($updateTaskInputDTO->id());

        if($task === null) {
            throw new TaskNotFoundException();
        }

        $assignedTo = null;
        if($updateTaskInputDTO->assignedTo() !== null) {
            $assignedTo = $this->authenticationRepository->getUserById($updateTaskInputDTO->assignedTo());
        }

        $dataFromDto = [
            'assigned_to' => $assignedTo?->id(),
            'text' => $updateTaskInputDTO->text(),
            'status' => $updateTaskInputDTO->status(),
        ];

        $dataToUpdate = array_filter($dataFromDto, function ($value) {
            return $value !== null;
        });

        return $this->taskRepository->updateById($task->id(), $dataToUpdate);
    }
}
