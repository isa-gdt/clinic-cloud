<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Controller\LoginController;
use Src\ToDoList\Infrastructure\Controller\DeleteTaskByIdController;
use Src\ToDoList\Infrastructure\Controller\GetAllTasksController;
use Src\ToDoList\Infrastructure\Controller\PostCreateTaskController;
use Src\ToDoList\Infrastructure\Controller\PutTaskByIdController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',LoginController::class);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/tasks',GetAllTasksController::class);
    Route::post('/tasks', PostCreateTaskController::class);
    Route::delete('/tasks/{id}', DeleteTaskByIdController::class);
    Route::put('/tasks/{id}', PutTaskByIdController::class);
});

