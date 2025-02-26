<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Src\ToDoList\Application\UseCase\CreateTaskUseCase;
use Src\ToDoList\Infrastructure\Transformer\TaskTransformer;

class PostCreateTaskController
{
    private const STATUS = 201;

    public function __construct(
        private readonly CreateTaskUseCase $postCreateTaskUseCase,
        private readonly TaskTransformer $taskTransformer
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->get('authenticated_user');

        $data =[
            'assigned_to' => $request->get('assigned_to'),
            'text' => $request->get('text'),
            'status'=> $request->get('status')
        ];

        $dto = new CreateTaskInputDTO($data, $user);

        $result = $this->postCreateTaskUseCase->execute($dto);

        return new JsonResponse(
            $this->taskTransformer->transform($result),
            self::STATUS
        );
    }
}
