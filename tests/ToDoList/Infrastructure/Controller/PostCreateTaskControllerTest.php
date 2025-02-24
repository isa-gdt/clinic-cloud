<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Src\ToDoList\Application\UseCase\CreateTaskUseCase;
use Src\ToDoList\Domain\Task;
use Src\ToDoList\Infrastructure\Controller\PostCreateTaskController;
use Src\ToDoList\Infrastructure\Transformer\TaskTransformer;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class PostCreateTaskControllerTest extends TestCase
{
    private function mockUseCase(Task $task): CreateTaskUseCase
    {
        return Mockery::mock(CreateTaskUseCase::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($task)
            ->getMock();
    }

    private function mockTransformer(
        Task  $task,
        array $transformedTask
    ): TaskTransformer
    {
        return Mockery::mock(TaskTransformer::class)
            ->shouldReceive('transform')
            ->once()
            ->with($task)
            ->andReturn($transformedTask)
            ->getMock();
    }

    public function testPostCreateTask(): void
    {
        //Given
        $task = TaskMotherObject::buildDefault();

        $transformedTask = [
            'id' => 1,
            'created_by' => 'Creator',
            'assigned_to' => 'Assignee',
            'text' => 'Text',
            'status' => 'Status',
            'created_at' => '14/12/2024',
            'updated_at' => '13/01/2025'
        ];

        $user = [
            'id' => 1,
            'name' => 'Name',
            'email' => 'email@email.com',
            'password' => 'password'
        ];


        $sut = new PostCreateTaskController(
            $this->mockUseCase($task),
            $this->mockTransformer($task, $transformedTask)
        );

        $data = [
            'text' => 'Text',
            'assigned_to' => 2,
            'status' => 'Status'
        ];

        $request = Request::create('/tasks', 'POST', $data);
        $request->merge(['authenticated_user' => $user]);

        //When
        $result = $sut->__invoke($request);

        //Then
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(201, $result->getStatusCode());
        $decodedContent = json_decode($result->getContent(), true);
        $this->assertEquals($transformedTask, $decodedContent);
    }
}
