<?php

declare(strict_types=1);

namespace Src\ToDoList\Domain\Exception;

class TaskNotFoundException extends \Exception
{
    const MESSAGE = 'Task Not Found';
    public function __construct()
    {
        parent::__construct(self::MESSAGE, 404);
    }
}
