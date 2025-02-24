<?php

declare(strict_types=1);

namespace Tests\ToDoList\Infrastructure\Transformer;

use PHPUnit\Framework\TestCase;
use Src\ToDoList\Infrastructure\Transformer\TaskTransformer;
use Tests\ToDoList\Domain\MotherObject\TaskMotherObject;

class TaskTransformerTest extends TestCase
{
    public function testTransformSuccess(): void
    {
        //Given
        $task = TaskMotherObject::buildDefault();

        //When
        $sut = new TaskTransformer();
        $result = $sut->transform($task);

        //Then
        $this->assertEquals([
            'id' => 1,
            'created_by' => 'UserName',
            'assigned_to' => 'UserName',
            'text' => 'Text',
            'status' => 'Status',
            'created_at' => '14/12/2024',
            'updated_at' => '13/01/2025'
        ], $result);
    }
}
