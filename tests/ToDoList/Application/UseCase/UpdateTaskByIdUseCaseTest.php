<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\UseCase;

use Illuminate\Support\Facades\Validator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Auth\Domain\Repository\AuthenticationRepositoryInterface;
use Src\Auth\Domain\User;
use Src\ToDoList\Application\InputDTO\UpdateTaskInputDTO;
use Src\ToDoList\Application\UseCase\UpdateTaskByIdUseCase;
use Src\ToDoList\Domain\Exception\TaskNotFoundException;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;
use Tests\Auth\MotherObject\UserMotherObject;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class UpdateTaskByIdUseCaseTest extends TestCase
{

    private function mockTaskRepositoryInterface(Task $result): TaskRepositoryInterface
    {
        return Mockery::mock(TaskRepositoryInterface::class)
            ->shouldReceive('updateById', 'getById')
            ->once()
            ->andReturn($result)
            ->getMock();
    }

    private function mockAuthRepositoryInterface (User $result): AuthenticationRepositoryInterface
    {
        return Mockery::mock(AuthenticationRepositoryInterface::class)
            ->shouldReceive('getUserById')
            ->once()
            ->andReturn($result)
            ->getMock();
    }

    public function testValidUpdateTaskByIdUseCase(): void
    {
        // Given
        Validator::shouldReceive('make')
            ->andReturn(Mockery::mock(\Illuminate\Validation\Validator::class, function ($mock) {
                $mock->shouldReceive('fails')->andReturn(false);
            }));

        $task = TaskMotherObject::buildDefault();
        $user = UserMotherObject::buildDefault();

        $taskRepository = $this->mockTaskRepositoryInterface($task);
        $authRepository = $this->mockAuthRepositoryInterface($user);
        $dtoData = [
            'id' => 1,
            'assigned_to' => 33,
            'text' => 'Text',
            'status'=> 'Status'
        ];

        $dto = new UpdateTaskInputDTO($dtoData);

        $sut = new UpdateTaskByIdUseCase($taskRepository, $authRepository);

        //When
        $result = $sut->execute($dto);

        //Then
        $this->assertEquals($task, $result);
    }

    private function mockTaskRepositoryInterfaceReturnsNull(): TaskRepositoryInterface
    {
        return Mockery::mock(TaskRepositoryInterface::class)
            ->shouldReceive('getById')
            ->once()
            ->andReturn(null)
            ->getMock();
    }

    private function mockAuthRepositoryInterfaceReturnsNull(): AuthenticationRepositoryInterface
    {
        return Mockery::mock(AuthenticationRepositoryInterface::class)
            ->shouldReceive('getUserById')
            ->andReturn(null)
            ->getMock();
    }

    public function testUpdateTaskByIdUseCaseThrowsTaskNotFoundException(): void
    {
        // Given
        Validator::shouldReceive('make')
            ->andReturn(Mockery::mock(\Illuminate\Validation\Validator::class, function ($mock) {
                $mock->shouldReceive('fails')->andReturn(false);
            }));

        $taskRepository = $this->mockTaskRepositoryInterfaceReturnsNull();
        $userRepository = $this->mockAuthRepositoryInterfaceReturnsNull();
        $dtoData = [
            'id' => 1,
            'assigned_to' => 33,
            'text' => 'Text',
            'status'=> 'Status'
        ];

        $dto = new UpdateTaskInputDTO($dtoData);

        $sut = new UpdateTaskByIdUseCase($taskRepository, $userRepository);

        //Then
        $this->expectException(TaskNotFoundException::class);

        //When
        $sut->execute($dto);
    }
}
