<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Controller;

use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\ToDoList\Application\InputDTO\DeleteTaskInputDTO;
use Src\ToDoList\Application\UseCase\DeleteTaskByIdUseCase;
use Src\ToDoList\Infrastructure\Controller\DeleteTaskByIdController;

class DeleteTaskByIdControllerTest extends TestCase
{
    private function mockUseCase(DeleteTaskInputDTO $dto): DeleteTaskByIdUseCase
    {
        return Mockery::mock(DeleteTaskByIdUseCase::class)
            ->shouldReceive('execute')
            ->once()
            ->getMock();
    }

    public function testDeleteTaskById(): void
    {
        //Given
        $data = [
            'id' => 1,
        ];
        $dto = new DeleteTaskInputDTO($data);
        $useCase = $this->mockUseCase($dto);

        $sut = new DeleteTaskByIdController($useCase);

        $request = Request::create('/tasks/1', 'DELETE');

        //When
        $result = $sut->__invoke($request, '1');

        //Then
        $this->assertEquals(204, $result->getStatusCode());
    }
}
