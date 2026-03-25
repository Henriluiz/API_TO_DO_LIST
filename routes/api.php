<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TarefasController;
use App\Http\Controllers\AuthUserController;

Route::post('/createUser', [UsersController::class, 'createUser']);
Route::post('/login', [UsersController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
        // User UsersController
        Route::patch('/updateUser', [UsersController::class, 'updateUser']);
        Route::get('/user', [UsersController::class, 'user']);
        Route::post('/logout', [UsersController::class, 'logout']);
        Route::delete('/deleteUser', [UsersController::class, 'deleteUser']);


        // Tarefa TarefasController
        Route::post('/createTar', [TarefasController::class, 'createTar']);
        Route::get('/tarefa', [TarefasController::class, 'tarefa']);
        Route::get('/show/{nome}', [TarefasController::class, 'show']);
        Route::patch('/update/{id}', [TarefasController::class, 'update']);
        Route::delete('/excluir/{id}', [TarefasController::class, 'excluir']);
});

