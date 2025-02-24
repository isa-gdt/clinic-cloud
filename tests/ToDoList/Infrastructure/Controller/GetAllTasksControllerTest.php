<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;
use Src\ToDoList\Application\UseCase\GetAllTasksUseCase;
use Src\ToDoList\Domain\TaskCollection;
use Src\ToDoList\Infrastructure\Controller\GetAllTasksController;
use Src\ToDoList\Infrastructure\Transformer\TaskCollectionTransformer;
use Tests\ToDoList\Domain\MotherObject\TaskCollectionMotherObject;

class GetAllTasksControllerTest extends TestCase
{
    private function mockUseCase(TaskCollection $taskCollection): GetAllTasksUseCase
    {
        return Mockery::mock(GetAllTasksUseCase::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($taskCollection)
            ->getMock();
    }

    private function mockTransformer(
        TaskCollection $taskCollection,
        array $transformedTasks
    ): TaskCollectionTransformer
    {
        return Mockery::mock(TaskCollectionTransformer::class)
            ->shouldReceive('transform')
            ->once()
            ->with($taskCollection)
            ->andReturn($transformedTasks)
            ->getMock();
    }

    public function testGetAllTasks(): void
    {
        //Given
        $taskCollection = TaskCollectionMotherObject::buildDefault();

        $transformedTasks =  [
            'id' => 1,
            'created_by' => 'Creator',
            'assigned_to' => 'Assignee',
            'text' => 'Text',
            'status' => 'Status',
            'created_at' => '14/12/2024',
            'updated_at' => '13/01/2025'
        ];

        $sut = new GetAllTasksController(
            $this->mockUseCase($taskCollection),
            $this->mockTransformer($taskCollection, $transformedTasks)
        );

        $request = Request::create('/tasks', 'GET');

        //When
        $result = $sut->__invoke($request);

        //Then
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
        $decodedContent = json_decode($result->getContent(), true);
        $this->assertEquals($transformedTasks, $decodedContent);

    }
}
