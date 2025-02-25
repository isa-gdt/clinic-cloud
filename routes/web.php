<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Controller\LoginController;
use Src\ToDoList\Infrastructure\Controller\DeleteTaskByIdController;
use Src\ToDoList\Infrastructure\Controller\GetAllTasksController;
use Src\ToDoList\Infrastructure\Controller\PostCreateTaskController;
use Src\ToDoList\Infrastructure\Controller\PutTaskByIdController;

Route::get('/', function () {
    return response()->file(public_path('index.html'));
});

Route::get('/login', function () {
    return response()->file(public_path('index.html'));
});

Route::post('/api/login',LoginController::class);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/api/tasks',GetAllTasksController::class);
    Route::post('/api/tasks', PostCreateTaskController::class);
    Route::delete('/api/tasks/{id}', DeleteTaskByIdController::class);
    Route::put('/api/tasks/{id}', PutTaskByIdController::class);
});
