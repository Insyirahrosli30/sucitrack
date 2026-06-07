<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\MenstrualController;
use App\Http\Controllers\QadaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Menstrual Records
    Route::get('/menstrual_records/end', [MenstrualController::class, 'endCycle'])
        ->name('menstrual_records.end');

    Route::resource('menstrual_records', MenstrualController::class);

    // Qada
    Route::get('/qada', [QadaController::class, 'index'])
        ->name('qada.index');

    // Complete Qada
    Route::post('/dashboard/complete-qada/{id}', [DashboardController::class, 'completeQada'])
        ->name('dashboard.complete-qada');

});

require __DIR__.'/auth.php';