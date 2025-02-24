<?php

declare(strict_types=1);

namespace Tests\Auth\Application\UseCase;

use Mockery;
use Mockery\Mock;
use Src\Auth\Application\InputDTO\LoginInputDTO;
use Src\Auth\Application\UseCase\LoginUseCase;
use Src\Auth\Domain\Exception\InvalidCredentialsException;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUseCaseTest extends TestCase
{
    public function testLoginSuccess(): void
    {
        // Given
        $dataDto = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $dto = new LoginInputDTO($dataDto);

        $expectedToken = 'mocked-jwt-token';

        JWTAuth::shouldReceive('attempt')
            ->once()
            ->andReturn($expectedToken);


        $useCase = new LoginUseCase();

        // When
        $result = $useCase->execute($dto);

        // Then
        $this->assertEquals($expectedToken, $result);
    }

    public function testLoginFailsAndThrowException(): void
    {
        // Given
        $dataDto = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $dto = new LoginInputDTO($dataDto);

        JWTAuth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'test@test.com', 'password' => 'password'])
            ->andThrow(InvalidCredentialsException::class);


        $useCase = new LoginUseCase();

        //Then
        $this->expectException(InvalidCredentialsException::class);

        // When
        $result = $useCase->execute($dto);
    }
}
