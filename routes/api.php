<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarbeariaController;

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



        Route::prefix('barbearias')->group(function () {
            Route::get('',              [BarbeariaController::class, 'index']);
            Route::get('/{id}',         [BarbeariaController::class, 'show'])  ->whereNumber('id');;
            Route::post('',             [BarbeariaController::class, 'store']);
            Route::put('/{id}',         [BarbeariaController::class, 'update']);
            Route::patch('/{id}',       [BarbeariaController::class, 'update']);
            Route::delete('/{id}',      [BarbeariaController::class, 'destroy']);
            Route::get('/search',       [BarbeariaController::class, 'search']);
        });
    });
});
