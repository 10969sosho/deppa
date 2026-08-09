<?php

use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\PlayerController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/google', GoogleAuthController::class)->name('api.auth.google');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/player', [PlayerController::class, 'store'])->name('api.player.store');
    Route::put('/player/{id}/finish', [PlayerController::class, 'finish'])->name('api.player.finish');
    Route::get('/player/{id}/report', [PlayerController::class, 'report'])->name('api.player.report');
    Route::get('/player/{id}/certificate', [PlayerController::class, 'certificate'])->name('api.player.certificate');
});
