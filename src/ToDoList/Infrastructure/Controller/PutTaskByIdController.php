<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\ToDoList\Application\InputDTO\UpdateTaskInputDTO;
use Src\ToDoList\Application\UseCase\UpdateTaskByIdUseCase;
use Src\ToDoList\Infrastructure\Transformer\TaskTransformer;

class PutTaskByIdController
{
    public function __construct(
        private readonly UpdateTaskByIdUseCase $updateTaskByIdUseCase,
        private readonly TaskTransformer $taskTransformer)
    {
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $data = [
            'id' => $id,
            'assigned_to' => $request->get('assigned_to'),
            'text' => $request->get('text'),
            'status'=> $request->get('status')
        ];

        $dto = new UpdateTaskInputDTO($data);

        $result = $this->updateTaskByIdUseCase->execute($dto);

        $response = $this->taskTransformer->transform($result);
        return new JsonResponse($response, 201);
    }
}
