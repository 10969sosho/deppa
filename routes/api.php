<?php

use App\Http\Controllers\Api\NameAuthController;
use App\Http\Controllers\Api\PlayerController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', NameAuthController::class)->name('api.auth.login');
Route::post('/auth/register', [PlayerController::class, 'store'])->name('api.auth.register');
Route::post('/player', [PlayerController::class, 'store'])->name('api.player.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/player/{name}/finish', [PlayerController::class, 'finish'])->name('api.player.finish');
    Route::get('/player/{name}/report', [PlayerController::class, 'report'])->name('api.player.report');
    Route::get('/player/{name}/certificate', [PlayerController::class, 'certificate'])->name('api.player.certificate');
});
