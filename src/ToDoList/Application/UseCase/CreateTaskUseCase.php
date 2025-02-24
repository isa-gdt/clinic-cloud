<?php

declare(strict_types=1);

namespace Src\ToDoList\Application\UseCase;

use Src\Auth\Domain\Repository\AuthenticationRepositoryInterface;
use Src\Auth\Domain\User;
use Src\Auth\Infrastructure\Repository\AuthenticationRepository;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;
use Src\ToDoList\Infrastructure\Repository\TaskRepository;

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
        if($taskInputDTO->assignedTo() !== null){
            $assignedTo = $this->authenticationRepository->getUserById($taskInputDTO->assignedTo());
        }

        $task = new Task(
            id: null,
            createdBy: new User(100,'a','b','c'),
            assignedTo: $assignedTo,
            text: $taskInputDTO->text(),
            status: $taskInputDTO->status(),
            createdAt: null,
            updatedAt: null
        );

        return $this->taskRepository->save($task);
    }
}
