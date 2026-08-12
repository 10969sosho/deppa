<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\PlayerController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::redirect('/dashboard', '/');

Route::prefix('players')->name('admin.players.')->group(function () {
    Route::get('/', [PlayerController::class, 'index'])->name('index');
    Route::get('/{id}', [PlayerController::class, 'show'])->name('show');
});

Route::prefix('export')->name('admin.export.')->group(function () {
    Route::get('/excel', [ExportController::class, 'excel'])->name('excel');
    Route::get('/pdf', [ExportController::class, 'pdf'])->name('pdf');
});

Route::get('/test/report/{id}', [PlayerController::class, 'testReport'])->name('admin.players.test-report');
Route::get('/test/certificate/{id}', [PlayerController::class, 'testCertificate'])->name('admin.players.test-certificate');

Route::get('{any}', fn (): RedirectResponse => redirect()->route('admin.dashboard'))->where('any', '.*');
