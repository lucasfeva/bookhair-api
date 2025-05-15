<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\AuthController;

Route::prefix('/v1')->name('api.v1')->group(function () {

    
    Route::post('auth/register',   [AuthController::class, 'register']);
    Route::post('auth/login',      [AuthController::class, 'login']);



});
