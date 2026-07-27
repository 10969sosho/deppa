<?php

use App\Http\Controllers\Api\PlayerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('player', PlayerController::class)->only(['store']);
