<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\InputDTO;

use Src\Common\Application\Exception\ValidationException;
use Src\ToDoList\Application\InputDTO\UpdateTaskInputDTO;
use Tests\TestCase;

class UpdateTaskInputDTOTest extends TestCase
{
    public function testUpdateTaskInputDTOThrowsValidationError(): void
    {
        //given
        $data = [];

        //Then
        $this->expectException(ValidationException::class);

        //When
        try {
            new UpdateTaskInputDTO($data);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Validation Error');
            $this->assertEquals([
                "You need a valid id!",
            ], $e->errors());
            throw $e;
        }
    }
}
