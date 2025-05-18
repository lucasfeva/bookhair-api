<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\AuthController;

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
});
