<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\LapanganController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('lapangan', LapanganController::class)->names('api.lapangan');

    Route::post('/booking', [BookingController::class, 'store']);
    Route::get('/riwayat-booking', [BookingController::class, 'riwayat']);
    Route::post('/booking/{booking}/upload-bukti', [BookingController::class, 'upload']);
});
