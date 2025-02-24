<?php

declare(strict_types=1);

namespace Tests\Auth\Application\InputDTO;

use Src\Auth\Application\InputDTO\LoginInputDTO;
use Src\Common\Application\Exception\ValidationException;
use Tests\TestCase;

class LoginInputDTOTest extends TestCase
{
    public function testLoginInputDTOThrowsValidationError():void
    {
        //Given
        $data = [];

        //Then
        $this->expectException(ValidationException::class);

        //When
        try {
            new LoginInputDTO($data);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Validation Error');
            $this->assertEquals([
                "You need a valid email address!",
                "You need a valid password!"
            ], $e->errors());
            throw $e;
        }
    }

}
