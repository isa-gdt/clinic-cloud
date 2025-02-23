<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Controller\LoginController;
use Src\ToDoList\Infrastructure\Controller\GetAllTasksController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',LoginController::class);

//todo: agrupar rutas por middleware
//Route::middleware(['first'])->group(function () {
Route::get('/tasks',GetAllTasksController::class);
