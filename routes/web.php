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

    // Dashboard (ONLY ONE)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Optional: if you need prayer data inside dashboard, merge inside controller (not route)

    // Menstrual CRUD (FULL RESOURCE)
    Route::get('/menstrual_records/end', [MenstrualController::class, 'endCycle'])
    ->name('menstrual_records.end');
    
    Route::resource('menstrual_records', MenstrualController::class);

    // Qada page
    Route::get('/qada', [QadaController::class, 'index'])
        ->name('qada.index');

    // Complete Qada
    Route::post('/dashboard/complete-qada/{id}', [DashboardController::class, 'completeQada'])
        ->name('dashboard.complete-qada');
});

require __DIR__.'/auth.php';