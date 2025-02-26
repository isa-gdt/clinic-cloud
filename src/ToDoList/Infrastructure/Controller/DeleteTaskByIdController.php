<?php

declare(strict_types=1);

namespace Src\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\ToDoList\Application\InputDTO\DeleteTaskInputDTO;
use Src\ToDoList\Application\UseCase\DeleteTaskByIdUseCase;

class DeleteTaskByIdController
{
    private const STATUS = 204;

    public function __construct(private readonly DeleteTaskByIdUseCase $deleteTaskUseCase)
    {
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $data = [
            'id' => $id
        ];

        $dto = new DeleteTaskInputDTO($data);

        $this->deleteTaskUseCase->execute($dto);

        return new JsonResponse(status: self::STATUS);
    }
}
