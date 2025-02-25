<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Auth\Application\InputDTO\LoginInputDTO;
use Src\Auth\Application\UseCase\LoginUseCase;

class LoginController
{
    public function __construct(
        private readonly LoginUseCase $loginUseCase
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $dto = new LoginInputDTO($data);

        $token = $this->loginUseCase->execute($dto);

        return response()->json([$token], 200);
    }
}
