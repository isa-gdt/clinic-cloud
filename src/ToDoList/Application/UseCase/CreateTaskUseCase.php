<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\Auth\Domain\Repository\AuthenticationRepositoryInterface;
use Src\Auth\Domain\User;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;

class CreateTaskUseCase
{
    public function __construct(
        private readonly AuthenticationRepositoryInterface $authenticationRepository,
        private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    public function execute(CreateTaskInputDTO $taskInputDTO): Task
    {
        $assignedTo = null;
        if ($taskInputDTO->assignedTo() !== null) {
            $assignedTo = $this->authenticationRepository->getUserById($taskInputDTO->assignedTo());
        }

        $createdBy = new User (
            id: $taskInputDTO->createdBy()['id'],
            name: $taskInputDTO->createdBy()['name'],
            email: $taskInputDTO->createdBy()['email'],
            password: $taskInputDTO->createdBy()['password'],
        );

        $task = new Task(
            id: null,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: $taskInputDTO->text(),
            status: $taskInputDTO->status(),
            createdAt: null,
            updatedAt: null
        );

        return $this->taskRepository->save($task);
    }
}
