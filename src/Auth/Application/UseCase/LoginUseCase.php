<?php

declare(strict_types=1);

namespace Src\Auth\Application\UseCase;

use Src\Auth\Application\InputDTO\LoginInputDTO;
use Src\Auth\Domain\Exception\InvalidCredentialsException;
use Src\Auth\Infrastructure\Exception\TokenCreationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUseCase
{
    public function execute(LoginInputDTO $data): string
    {
        $credentials = [
            'email' => $data->email(),
            'password' => $data->password(),
        ];

        try{
            $token = JWTAuth::attempt($credentials);
            if(!$token){
                throw new InvalidCredentialsException();
            }
        } catch (JWTException $e){
            throw new TokenCreationException($e->getMessage());
        }

        return $token;
    }
}
