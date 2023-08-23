<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\SuratPengantar\PklController;

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
    return view('website.home.index');
})->name('index');

Route::group(['prefix' => 'surat-pengantar', 'as' => 'surat-pengantar.'], function () {
    Route::get('/pkl', [PklController::class, 'index'])->name('pkl');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bagian Surat Pengantar
    Route::group(['prefix' => 'surat-pengantar', 'as' => 'surat-pengantar.'], function () {
        Route::get('/pkl', [PklController::class, 'index'])->name('pkl');
    });
});

require __DIR__.'/auth.php';
