<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Repository;

use Illuminate\Support\Facades\Validator;
use Mockery\Mock;
use Src\Common\Infrastructure\Exception\PersistenceException;
use Src\ToDoList\Domain\Task;
use Src\ToDoList\Infrastructure\Repository\TaskRepository;
use Tests\Auth\MotherObject\UserMotherObject;
use Tests\TestCase;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class TaskRepositoryTest extends TestCase
{

    public function testGetAll():void
    {
        //Given
        $repository = new TaskRepository();
        $page = 1;
        $limit = 3;

        //When
        $tasks = $repository->getAll($page, $limit);


        //Then
        $this->assertCount($limit, $tasks->collection());
        foreach ($tasks as $task) {
            $this->assertNotNull($task->id);
            $this->assertNotNull($task->createdBy);
            $this->assertNotNull($task->assignedTo);
        }
    }

    public function testSaveAndGetById(): void
    {
        //Given
        $createdBy = UserMotherObject::buildDefault(id: 99, name: 'Test Creator');
        $assignedTo = UserMotherObject::buildDefault(id: 99, name: 'Test Assignee');

        $domainTask = TaskMotherObject::buildDefault(
            id: 100,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: 'Test'
        );

        $repository = new TaskRepository();

        // When
        $savedTask = $repository->save($domainTask);

        // Then
        $this->assertNotNull($savedTask->id(), 'La tarea guardada debe tener un id asignado');

        $retrievedTask = $repository->getById($savedTask->id());

        $this->assertInstanceOf(Task::class, $retrievedTask);
        $this->assertEquals($savedTask->id(), $retrievedTask->id());
        $this->assertEquals($savedTask->text(), $retrievedTask->text());
        $this->assertEquals($savedTask->status(), $retrievedTask->status());

        $repository->deleteById($savedTask->id());
    }

    public function testUpdateById(): void
    {
        //Given
        $createdBy = UserMotherObject::buildDefault(id: 99, name: 'Test Creator');
        $assignedTo = UserMotherObject::buildDefault(id: 99, name: 'Test Assignee');

        $domainTask = TaskMotherObject::buildDefault(
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: 'Test'
        );

        $dataForUpdate = [
            'assigned_to' => 99,
            'text' => 'Updated Text',
            'status' => 'completed',
        ];
        $repository = new TaskRepository();

        $savedTask = $repository->save($domainTask);

        //When
        $updatedTask = $repository->updateById($savedTask->id(), $dataForUpdate);

        //Then
        $this->assertInstanceOf(Task::class, $updatedTask);
        $this->assertEquals($savedTask->id(), $updatedTask->id());
        $this->assertEquals($dataForUpdate['assigned_to'], $updatedTask->assignedTo()->id());
        $this->assertEquals($dataForUpdate['text'], $updatedTask->text());
        $this->assertEquals($dataForUpdate['status'], $updatedTask->status());

        $repository->deleteById($savedTask->id());
    }

    public function testDeleteById(): void
    {
        //Given
        $createdBy = UserMotherObject::buildDefault(id: 99, name: 'Test Creator');
        $assignedTo = UserMotherObject::buildDefault(id: 99, name: 'Test Assignee');

        $domainTask = TaskMotherObject::buildDefault(
            id: 100,
            createdBy: $createdBy,
            assignedTo: $assignedTo,
            text: 'Test'
        );

        $repository = new TaskRepository();
        $savedTask = $repository->save($domainTask);

        //When
        $repository->deleteById($savedTask->id());

        //Then
        $this->assertDatabaseMissing('tasks', ['id' => $savedTask->id()]);
    }
}
