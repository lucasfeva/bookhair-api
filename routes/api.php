<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ServicoController;
use App\Http\Controllers\API\BarbeariaController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\AgendamentoController;
use App\Http\Controllers\API\ProfissionalController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refreshToken']);
        });
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('auth:sanctum')->prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'getProfile']);
            Route::put('/', [UserController::class, 'updateProfile']);
        });

        Route::prefix('barbearias')->group(function () {
            Route::get('search', [BarbeariaController::class, 'search']);
            Route::get('nearby', [BarbeariaController::class, 'nearby']);
            Route::get('{id}/servicos', [BarbeariaController::class, 'servicos']);
            Route::get('{id}/profissionais', [BarbeariaController::class, 'profissionais']);
            Route::get('{id}/agenda', [BarbeariaController::class, 'agenda']);
            Route::apiResource('', BarbeariaController::class)->parameters(['' => 'id'])->except(['create', 'edit']);
        });

        Route::prefix('servicos')->group(function () {
            Route::get('', [ServicoController::class, 'index']);
            Route::get('/{id}', [ServicoController::class, 'show']);
            Route::post('', [ServicoController::class, 'store']);
            Route::put('/{id}', [ServicoController::class, 'update']);
            Route::delete('/{id}', [ServicoController::class, 'destroy']);
        });

        Route::prefix('profissionais')->group(function () {
            Route::get('', [ProfissionalController::class, 'index']);
            Route::get('/{id}', [ProfissionalController::class, 'show']);
            Route::get('/{id}/horarios', [ProfissionalController::class, 'horarios']);
            Route::get('/{id}/servicos', [ProfissionalController::class, 'servicos']);
            Route::post('', [ProfissionalController::class, 'store']);
            Route::put('/{id}', [ProfissionalController::class, 'update']);
            Route::delete('/{id}', [ProfissionalController::class, 'destroy']);
            Route::post('/{id}/servicos/{serviceId}', [ProfissionalController::class, 'assignService']);
            Route::delete('/{id}/servicos/{serviceId}', [ProfissionalController::class, 'removeService']);
        });

        Route::prefix('agendamentos')->group(function () {
            Route::get('', [AgendamentoController::class, 'index']);
            Route::get('/{id}', [AgendamentoController::class, 'show']);
            Route::post('', [AgendamentoController::class, 'store']);
            Route::put('/{id}', [AgendamentoController::class, 'update']);
            Route::post('/{id}/cancel', [AgendamentoController::class, 'cancel']);
            Route::get('/history/{userId}', [AgendamentoController::class, 'history']);
        });

        Route::prefix('dashboard')->group(function () {
            Route::get('stats', [DashboardController::class, 'statsMonthly']);
        });

        Route::prefix('reviews')->group(function () {
            Route::post('/', [ReviewController::class, 'store']);
            Route::get('/barbearia/{barbeariaId}', [ReviewController::class, 'index']);
            Route::delete('/{id}', [ReviewController::class, 'destroy']);
        });
    });
});
