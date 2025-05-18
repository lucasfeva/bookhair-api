<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarbeariaController;
use App\Http\Controllers\API\UserController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register',     [AuthController::class, 'register']);
        Route::post('login',        [AuthController::class, 'login'])->name('login');
        // abaixo, protegidos por token:
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout',       [AuthController::class, 'logout']);
            Route::post('refresh',      [AuthController::class, 'refreshToken']);
        });
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('auth:sanctum')->prefix('user')->group(function () {
            Route::get('/',       [UserController::class, 'getProfile']);
            Route::put('/',       [UserController::class, 'updateProfile']);
        });


        Route::prefix('barbearias')->group(function () {
            // buscas especiais
            Route::get('search',       [BarbeariaController::class, 'search']);
            Route::get('nearby',       [BarbeariaController::class, 'nearby']);
            Route::get('{id}/servicos', [BarbeariaController::class, 'servicos']);
            Route::get('{id}/profissionais', [BarbeariaController::class, 'profissionais']);
            Route::get('{id}/agenda',  [BarbeariaController::class, 'agenda']);

            // CRUD (index, store, update, destroy) — observe: caminho “vazio” para resource
            Route::apiResource('', BarbeariaController::class)
                ->parameters(['' => 'id'])
                ->except(['create', 'edit']);
        });
    });
});
