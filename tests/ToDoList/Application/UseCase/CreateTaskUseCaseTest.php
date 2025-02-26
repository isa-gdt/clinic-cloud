<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\UseCase;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Auth\Domain\Repository\UserRepositoryInterface;
use Src\Auth\Domain\User;
use Src\Common\Application\Exception\ValidationException;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Src\ToDoList\Application\UseCase\CreateTaskUseCase;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\Task;
use Tests\Auth\MotherObject\UserMotherObject;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class CreateTaskUseCaseTest extends TestCase
{
    private function mockAuthenticationRepositoryInterface(User $result): UserRepositoryInterface
    {
        return Mockery::mock(UserRepositoryInterface::class)
            ->shouldReceive('getUserById')
            ->once()
            ->andReturn($result)
            ->getMock();
    }
    private function mockTaskRepositoryInterface(Task $result): TaskRepositoryInterface
    {
        return Mockery::mock(TaskRepositoryInterface::class)
            ->shouldReceive('save')
            ->once()
            ->andReturn($result)
            ->getMock();
    }

    public function testValidPostCreateTaskUseCase(): void
    {
        //Given
        Validator::shouldReceive('make')
            ->andReturn(Mockery::mock(\Illuminate\Validation\Validator::class, function ($mock) {
                $mock->shouldReceive('fails')->andReturn(false);
            }));

        $task = TaskMotherObject::buildDefault();
        $user = UserMotherObject::buildDefault();

        $authRepository = $this->mockAuthenticationRepositoryInterface($user);
        $taskRepository = $this->mockTaskRepositoryInterface($task);

        $user = [
            'id' => 1,
            'name' => 'Name',
            'email' => 'email@email.com',
            'password' => 'password',
        ];

        $dtoData = [
            'assigned_to' => 33,
            'text' => 'Text',
            'status'=> 'Status'
        ];

        $dto = new CreateTaskInputDTO($dtoData, $user);

        $sut = new CreateTaskUseCase($authRepository, $taskRepository);


        //When
        $result = $sut->execute($dto);

        //Then
        $this->assertEquals($task, $result);
        $this->assertIsArray($dto->createdBy());
    }
}
