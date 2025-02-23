<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain\Repository;

use Src\ToDoList\Domain\TaskCollection;

interface TaskRepositoryInterface
{
    public function getAll(): TaskCollection;
}
