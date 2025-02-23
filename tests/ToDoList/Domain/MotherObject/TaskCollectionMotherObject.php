<?php

declare(strict_types=1);

namespace Tests\ToDoList\Domain\MotherObject;

use Src\ToDoList\Domain\TaskCollection;

class TaskCollectionMotherObject
{
    public static function buildDefault(?int $totalElements = 1): TaskCollection
    {
        $collection = [];
        for ($i = 0; $i < $totalElements; $i++) {
            $collection[] = TaskMotherObject::buildDefault(id: $i + 1);
        }

        return new TaskCollection($collection);
    }
}
