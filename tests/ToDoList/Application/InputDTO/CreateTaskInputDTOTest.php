<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\InputDTO;

use Src\Common\Application\Exception\ValidationException;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Tests\TestCase;

class CreateTaskInputDTOTest extends TestCase
{

    public function testCreateTaskInputDTOThrowsValidationError(): void
    {

        //given
        $data = [];

        //Then
        $this->expectException(ValidationException::class);

        //When
        try {
            new CreateTaskInputDTO($data);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Validation Error');
            $this->assertEquals([
                "You need a valid text!",
                "You need a valid status!"
            ], $e->errors());
            throw $e;
        }
    }
}
