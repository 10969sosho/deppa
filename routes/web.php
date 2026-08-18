<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\PlayerController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->file(base_path('games/index.html'));
})->name('game');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/games/{path}', function (string $path) {
    $gamesDirectory = realpath(base_path('games'));
    $file = realpath(base_path('games/'.$path));

    abort_if(
        $gamesDirectory === false
            || $file === false
            || ! str_starts_with($file, $gamesDirectory.DIRECTORY_SEPARATOR)
            || ! is_file($file),
        404
    );

    return response()->file($file);
})->where('path', '.*')->name('game.asset');

Route::prefix('players')->name('admin.players.')->group(function () {
    Route::get('/', [PlayerController::class, 'index'])->name('index');
    Route::get('/{id}', [PlayerController::class, 'show'])->name('show');
    Route::delete('/{id}', [PlayerController::class, 'destroy'])->name('destroy');
});

Route::prefix('export')->name('admin.export.')->group(function () {
    Route::get('/excel', [ExportController::class, 'excel'])->name('excel');
    Route::get('/pdf', [ExportController::class, 'pdf'])->name('pdf');
});

Route::get('/test/report/{id}', [PlayerController::class, 'testReport'])->name('admin.players.test-report');
Route::get('/test/certificate/{id}', [PlayerController::class, 'testCertificate'])->name('admin.players.test-certificate');

Route::get('{any}', fn (): RedirectResponse => redirect()->route('admin.dashboard'))->where('any', '.*');
