<?php

<< HEAD >>
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\MenstrualController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

<< HEAD >>
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [PrayerController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
=======
Route::middleware(['auth'])->group(function () {
});

Route::resource('menstrual_records', MenstrualController::class);
>>>>>>> hanees/main

