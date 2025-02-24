<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\UseCase;

use Illuminate\Support\Facades\Validator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\ToDoList\Application\InputDTO\DeleteTaskInputDTO;
use Src\ToDoList\Application\UseCase\DeleteTaskByIdUseCase;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;

class DeleteTaskByIdUseCaseTest extends TestCase
{
    private function mockTaskRepositoryInterface(int $id): TaskRepositoryInterface
    {
        return Mockery::mock(TaskRepositoryInterface::class)
            ->shouldReceive('deleteById')
            ->once()
            ->with($id)
            ->getMock();
    }

    public function testValidDeleteTaskByIdUseCase(): void
    {
        //Given
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Mockery::mock(\Illuminate\Validation\Validator::class, function ($mock) {
                $mock->shouldReceive('fails')->andReturn(false);
            }));

        $id = 1;
        $dtoData = [
            'id' => $id,
        ];

        $taskRepository = $this->mockTaskRepositoryInterface($id);
        $dto = new DeleteTaskInputDTO($dtoData);

        $sut = new DeleteTaskByIdUseCase($taskRepository);

        //When
        $sut->execute($dto);

        //Then
        $this->assertTrue(true);
    }
}
