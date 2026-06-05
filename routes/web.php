
<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenstrualController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QadaController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Menstrual Records CRUD System
    Route::resource('menstrual_records', MenstrualController::class);

    Route::get('/qada', [QadaController::class, 'index'])->name('qada.index');
});

require __DIR__.'/auth.php';