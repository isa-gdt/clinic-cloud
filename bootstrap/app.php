<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Src\Auth\Domain\Exception\InvalidCredentialsException;
use Src\Auth\Infrastructure\Exception\TokenCreationException;
use Src\Common\Application\Exception\ValidationException;
use Src\Common\Infrastructure\Exception\PersistenceException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(
            except: ['/*']
        );

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            return new JsonResponse([
                'error' => $e->errors(),
            ], $e->getCode());
        });
        $exceptions->render(function (PersistenceException $e) {
           return new JsonResponse([
               'error' => $e->getMessage(),
           ], $e->getCode());
        });
        $exceptions->render(function (TokenCreationException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], $e->getCode());
        });
        $exceptions->render(function (InvalidCredentialsException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], $e->getCode());
        });
    })->create();
