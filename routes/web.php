<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

// 1. PLACE THE CALENDAR ROUTE HERE (OUTSIDE AUTH MIDDLEWARE)
Route::get('/calendar', fn () => view('calendar'))->name('calendar');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
});

require __DIR__.'/auth.php';