<?php

use App\Http\Controllers\Api\PlayerController;
use Illuminate\Support\Facades\Route;

Route::post('/player', [PlayerController::class, 'store'])->name('api.player.store');
Route::put('/player/{id}/finish', [PlayerController::class, 'finish'])->name('api.player.finish');
