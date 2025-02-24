<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\UseCase;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Auth\Domain\Repository\AuthenticationRepositoryInterface;
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
    private function mockAuthenticationRepositoryInterface(User $result): AuthenticationRepositoryInterface
    {
        return Mockery::mock(AuthenticationRepositoryInterface::class)
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
            ->once()
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

    public function testInvalidPostCreateTaskUseCaseThrowsValidationException(): void
    {

        //Then
        $this->expectException(ValidationException::class);

        //When
        Validator::shouldReceive('make')
            ->once()
            ->andReturn(Mockery::mock(\Illuminate\Validation\Validator::class, function ($mock) {
                $mock->shouldReceive('fails')->andReturn(true);
                $mock->shouldReceive('errors')->andReturn(new MessageBag([
                    'text' => ['You need a valid text!'],
                    'status' => ['You need a valid status!'],
                ]));
            }));

        $dtoData = [
            'created_by'  => 22,
            'assigned_to' => 33,
            'text'        => '',
            'status'      => 'Status',
        ];
        $userDto = [
            'id' => 1,
            'name' => 'Name',
            'email' => 'email@email.com',
            'password' => 'password',
        ];


        $task = TaskMotherObject::buildDefault();
        $repository = $this->mockTaskRepositoryInterface($task);
        $user = UserMotherObject::buildDefault();
        $authRepository = $this->mockAuthenticationRepositoryInterface($user);
        $dto = new CreateTaskInputDTO($dtoData, $userDto);

        $sut = new CreateTaskUseCase($authRepository, $repository);

        $sut->execute($dto);

    }
}
