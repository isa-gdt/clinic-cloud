<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\InputDTO;

use Src\Common\Application\Exception\ValidationException;
use Src\ToDoList\Application\InputDTO\DeleteTaskInputDTO;
use Src\ToDoList\Application\InputDTO\CreateTaskInputDTO;
use Tests\TestCase;

class DeleteTaskInputDTOTest extends TestCase
{
    public function testDeleteTaskInputDTOThrowsValidationError():void
    {
        //Given
        $data = [];

        //Then
        $this->expectException(ValidationException::class);

        //When
        try {
            new DeleteTaskInputDTO($data);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Validation Error');
            $this->assertEquals([
                "You need a valid id!",
            ], $e->errors());
            throw $e;
        }
    }


}
