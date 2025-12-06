<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/ping', fn() => response()->json(['ok' => true]));

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::middleware('auth:api')->prefix('/tickets')->group(function () {
        Route::get('/', [TicketController::class, 'getAll']);
        Route::get('/{id}', [TicketController::class, 'getById']);
        Route::post('/', [TicketController::class, 'create'])->middleware('role:user');
        Route::middleware('role:admin,agent')->group(function () {
            Route::post('/{ticket}/assign', [TicketController::class, 'assign']);
            Route::post('/{ticket}/status', [TicketController::class, 'setStatus']);
        });
        Route::post('/{ticket}/comment', [TicketController::class, 'comment']);
    });

});
