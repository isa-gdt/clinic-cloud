<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\ToDoList\Application\UseCase\GetAllTasksUseCase;
use Src\ToDoList\Domain\Repository\TaskRepositoryInterface;
use Src\ToDoList\Domain\TaskCollection;
use Tests\ToDoList\Domain\MotherObject\TaskCollectionMotherObject;

class GetAllTaskUseCaseTest extends TestCase
{

    private function mockTaskRepositoryInterface(TaskCollection $results): TaskRepositoryInterface
    {
        return Mockery::mock(TaskRepositoryInterface::class)
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($results)
            ->getMock();
    }

    public function testValidGetAllTaskUseCase(): void
    {
        //Given
        $taskCollection = TaskCollectionMotherObject::buildDefault(3);
        $repository = $this->mockTaskRepositoryInterface($taskCollection);

        $sut = new GetAllTasksUseCase($repository);

        //When
        $result = $sut->execute();

        //Then
        $this->assertEquals($taskCollection, $result);
    }
}
