<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Controller\LoginController;
use Src\ToDoList\Infrastructure\Controller\DeleteTaskByIdController;
use Src\ToDoList\Infrastructure\Controller\GetAllTasksController;
use Src\ToDoList\Infrastructure\Controller\GetTaskByIdController;
use Src\ToDoList\Infrastructure\Controller\PostCreateTaskController;
use Src\ToDoList\Infrastructure\Controller\PutTaskByIdController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',LoginController::class);

//todo: agrupar rutas por middleware
//Route::middleware(['first'])->group(function () {
Route::get('/tasks',GetAllTasksController::class);
Route::post('/tasks', PostCreateTaskController::class);
Route::delete('/tasks/{id}', DeleteTaskByIdController::class);
Route::put('/tasks/{id}', PutTaskByIdController::class);
