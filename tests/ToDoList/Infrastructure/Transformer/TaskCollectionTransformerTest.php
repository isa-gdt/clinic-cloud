<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Transformer;

use PHPUnit\Framework\TestCase;
use Src\ToDoList\Infrastructure\Transformer\TaskCollectionTransformer;
use Tests\ToDoList\Domain\MotherObject\TaskCollectionMotherObject;

class TaskCollectionTransformerTest extends TestCase
{
    public function testTransformSuccess(): void
    {
        //Given
        $taskCollection = TaskCollectionMotherObject::buildDefault();

        //When
        $sut = new TaskCollectionTransformer();
        $result = $sut->transform($taskCollection);

        //Then
        $this->assertEquals([
            [
                'id' => 1,
                'created_by' => 'UserName',
                'assigned_to' => 'UserName',
                'text' => 'Text',
                'status' => 'Status',
                'created_at' => '14/12/2024',
                'updated_at' => '13/01/2025'
            ]
        ], $result);
    }
}
