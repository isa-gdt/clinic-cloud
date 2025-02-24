<?php

declare(strict_types=1);

namespace Tests\Auth\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Src\Auth\Application\UseCase\LoginUseCase;
use Src\Auth\Infrastructure\Controller\LoginController;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    private function mockUseCase(string $token): LoginUseCase
    {
        return Mockery::mock(LoginUseCase::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($token)
            ->getMock();
    }
    public function testLogin():void
    {
        $token = 'Esto es un token';
        $data = [
            'email' => 'email@email.com',
            'password' => 'password'
        ];

        $sut = new LoginController($this->mockUseCase($token));
        $request = Request::create('/login', 'POST', $data);

        //When
        $result = $sut->__invoke($request);

        //Then
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(204, $result->getStatusCode());
        $decodedContent = json_decode($result->getContent(), true);
        $this->assertEquals($token, $decodedContent[0]);
    }
}
