<?php

declare(strict_types = 1);

namespace Src\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Src\ToDoList\Application\UseCase\GetAllTasksUseCase;
use Src\ToDoList\Infrastructure\Transformer\TaskCollectionTransformer;

class GetAllTasksController
{
    public function __construct(
        private readonly GetAllTasksUseCase $getAllTasksUseCase,
        private readonly TaskCollectionTransformer $taskCollectionTrasnformer
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        //use case
        $tasks = $this->getAllTasksUseCase->execute();

        //response
        return new JsonResponse($this->taskCollectionTrasnformer->transform($tasks));
    }
}
