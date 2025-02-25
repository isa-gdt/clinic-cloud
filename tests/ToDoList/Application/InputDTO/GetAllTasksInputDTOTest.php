<?php

declare(strict_types=1);

namespace Tests\ToDoList\Application\InputDTO;

use Src\Common\Application\Exception\ValidationException;
use Src\ToDoList\Application\InputDTO\GetAllTasksInputDTO;
use Tests\TestCase;

class GetAllTasksInputDTOTest extends TestCase
{
    public function testGetAllTasksInputDTOThrowsValidationException(): void
    {
        // Given
        $data = [
            'limit' => 'a',
            'page' => 'a'
        ];

        //Then
       $this->expectException(ValidationException::class);

        //When
        try {
            new GetAllTasksInputDTO($data);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Validation Error');
            $this->assertEquals([
                "You need a valid limit!",
                "You need a valid page!"
            ], $e->errors());
            throw $e;
        }
    }

}
