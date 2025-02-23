<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain;

use PHPUnit\Framework\TestCase;
use Src\ToDoList\Domain\TaskCollection;
use Tests\ToDoList\Domain\MotherObject\TaskCollectionMotherObject;

class TaskCollectionTest extends TestCase
{
    public function testCreateCollection(): void
    {
        $taskCollection = TaskCollectionMotherObject::buildDefault(1);

        $this->assertEquals(1, $taskCollection->collection()[0]->id());
        $this->assertEquals('Creator', $taskCollection->collection()[0]->createdBy());
        $this->assertEquals('Assignee', $taskCollection->collection()[0]->assignedTo());
        $this->assertEquals('Text', $taskCollection->collection()[0]->text());
        $this->assertEquals('Status', $taskCollection->collection()[0]->status());
        $this->assertEquals('14/12/2024', $taskCollection->collection()[0]->createdAt());
        $this->assertEquals('13/01/2025', $taskCollection->collection()[0]->updatedAt());
    }

    public function testBuildFromRaw(): void
    {
        $task = [
            [
                'id' => 1,
                'created_by' => ['name' => 'Creator'],
                'assigned_to' => ['name' => 'Assignee'],
                'text' => 'Text',
                'status' => 'Status',
                'created_at' => '14/12/2024',
                'updated_at' => '13/01/2025'
            ]
        ];

        $taskCollection = TaskCollection::buildFromRaw($task);

        $this->assertInstanceOf(TaskCollection::class, $taskCollection);

        $this->assertEquals(1, $taskCollection->collection()[0]->id());
        $this->assertEquals('Creator', $taskCollection->collection()[0]->createdBy());
        $this->assertEquals('Assignee', $taskCollection->collection()[0]->assignedTo());
        $this->assertEquals('Text', $taskCollection->collection()[0]->text());
        $this->assertEquals('Status', $taskCollection->collection()[0]->status());
        $this->assertEquals('14/12/2024', $taskCollection->collection()[0]->createdAt());
        $this->assertEquals('13/01/2025', $taskCollection->collection()[0]->updatedAt());
    }
}
