<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenstrualController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Root URL redirection
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Authenticated Protected Group Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Core Dashboard Routing
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Muktamad POST Endpoint: Selesaikan isu klik butang "Done"
    Route::post('/dashboard/complete-qada/{id}', [DashboardController::class, 'completeQada'])->name('dashboard.complete-qada');

    // Standalone End Date Form Endpoint
    Route::put('/menstrual-records/{id}/end', [MenstrualController::class, 'logEndDate'])->name('menstrual_records.log_end');
    
    // Calendar View Resource Routing
    Route::get('/calendar', function () {
        // Kekal MenstrualRecords mengikut struktur projek kau
        $records = \App\Models\MenstrualRecords::where('user_id', Auth::id())
            ->get(['start_datetime as start', 'end_datetime as end']);
        return view('calendar', compact('records'));
    })->name('calendar');

    // History Table Resource Routes Mapping (Menyediakan menstrual_records.index)
    Route::resource('menstrual_records', MenstrualController::class);
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';