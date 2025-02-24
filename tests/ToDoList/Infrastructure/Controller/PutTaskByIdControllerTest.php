<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

use Src\ToDoList\Application\UseCase\UpdateTaskByIdUseCase;
use Src\ToDoList\Domain\Task;
use Src\ToDoList\Infrastructure\Controller\PutTaskByIdController;
use Src\ToDoList\Infrastructure\Transformer\TaskTransformer;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class PutTaskByIdControllerTest extends TestCase
{
    private function mockUseCase(Task $result): UpdateTaskByIdUseCase
    {
        return Mockery::mock(UpdateTaskByIdUseCase::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($result)
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

    public function testUpdateTaskById():void
    {
        // Given
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

        $sut = new PutTaskByIdController(
            $this->mockUseCase($task),
            $this->mockTransformer($task, $transformedTask)
        );

        $data = [
            'text' => 'Text',
            'assigned_to' => 2,
            'status' => 'Status'
        ];

        $request = Request::create('/tasks/1', 'PUT', $data);

        //When
        $result = $sut->__invoke($request, '1');

        //Then
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(201, $result->getStatusCode());
        $decodedContent = json_decode($result->getContent(), true);
        $this->assertEquals($transformedTask, $decodedContent);
    }
}
