<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenstrualController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Route targeting your Controller core logic
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Calendar Route (Queries database rows before returning the view)
    Route::get('/calendar', function () {
        $records = \App\Models\MenstrualRecords::where('user_id', Auth::id())
            ->get(['start_datetime as start', 'end_datetime as end']);
        return view('calendar', compact('records'));
    })->name('calendar');

    // Menstrual History Resources Mapping
    Route::resource('menstrual_records', MenstrualController::class);
    
    // Profile Management Routing
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';