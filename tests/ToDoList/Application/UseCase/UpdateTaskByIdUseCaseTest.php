<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\UseCase;

use Illuminate\Support\Facades\Validator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\ToDoList\Application\InputDTO\UpdateTaskInputDTO;
use Src\ToDoList\Application\UseCase\UpdateTaskByIdUseCase;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class UpdateTaskByIdUseCaseTest extends TestCase
{

    private function mockTaskRepositoryInterface(Task $result): TaskRepositoryInterface
    {
        return Mockery::mock(TaskRepositoryInterface::class)
            ->shouldReceive('updateById')
            ->once()
            ->andReturn($result)
            ->getMock();
    }

    public function testValidUpdateTaskByIdUseCase(): void
    {
        // Given
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Mockery::mock(\Illuminate\Validation\Validator::class, function ($mock) {
                $mock->shouldReceive('fails')->andReturn(false);
            }));

        $task = TaskMotherObject::buildDefault();

        $taskRepository = $this->mockTaskRepositoryInterface($task);
        $dtoData = [
            'id' => 1,
            'assigned_to' => 33,
            'text' => 'Text',
            'status'=> 'Status'
        ];

        $dto = new UpdateTaskInputDTO($dtoData);

        $sut = new UpdateTaskByIdUseCase($taskRepository);

        //When
        $result = $sut->execute($dto);

        //Then
        $this->assertEquals($task, $result);
    }
}
