<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Src\Auth\Domain\Exception\InvalidCredentialsException;
use Src\Auth\Domain\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $userModel = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            throw new InvalidCredentialsException();
        }

        $user = [
            'id' => $userModel->id,
            'name' => $userModel->name,
            'email' => $userModel->email,
            'password' => $userModel->password,
        ];

        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
