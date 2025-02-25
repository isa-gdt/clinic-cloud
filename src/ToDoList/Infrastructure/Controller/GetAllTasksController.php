<?php

declare(strict_types = 1);

namespace Src\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\ToDoList\Application\InputDTO\GetAllTasksInputDTO;
use Src\ToDoList\Application\UseCase\GetAllTasksUseCase;
use Src\ToDoList\Infrastructure\Transformer\TaskCollectionTransformer;

class GetAllTasksController
{
    public function __construct(
        private readonly GetAllTasksUseCase $getAllTasksUseCase,
        private readonly TaskCollectionTransformer $taskCollectionTransformer
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = [
          'page' => $request->query('page'),
          'limit' => $request->query('limit'),
        ];

        $dto = new GetAllTasksInputDTO($data);

        $tasks = $this->getAllTasksUseCase->execute($dto);

        return new JsonResponse($this->taskCollectionTransformer->transform($tasks));
    }
}
