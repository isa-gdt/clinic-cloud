<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Auth\Domain\User;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Src\ToDoList\Application\UseCase\CreateTaskUseCase;
use Src\ToDoList\Infrastructure\Transformer\TaskTransformer;

class PostCreateTaskController
{
    public function __construct(
        private readonly CreateTaskUseCase $postCreateTaskUseCase,
        private readonly TaskTransformer   $taskTransformer
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data =[
            //fixme: cambiar el created by cuando tenga la info del usuario logueado
            'created_by' => 100,
            'assigned_to' => $request->get('assigned_to'),
            'text' => $request->get('text'),
            'status'=> $request->get('status')
        ];

        $dto = new CreateTaskInputDTO($data);

        $result = $this->postCreateTaskUseCase->execute($dto);

        $response = $this->taskTransformer->transform($result);
        return new JsonResponse($response, 201);
    }
}
