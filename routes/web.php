<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Controller Surat Pengantar
use App\Http\Controllers\Website\SuratPengantar\PklController;
use App\Http\Controllers\Website\SuratPengantar\SkripsiController;
use App\Http\Controllers\Website\SuratPengantar\PenelitianMatkulController;

// Controller Surat Keterangan
use App\Http\Controllers\Website\SuratKeterangan\AktifKuliahController;
use App\Http\Controllers\Website\SuratKeterangan\BebasSanksiAkademikController;

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
        // Bagian PKL
        Route::group(['prefix' => 'pkl', 'as' => 'pkl.'], function () {
            Route::get('/', [PklController::class, 'index'])->name('index');
            Route::post('/', [PklController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [PklController::class, 'preview'])->name('preview');
        });

        // Bagian Skripsi
        Route::group(['prefix' => 'skripsi', 'as' => 'skripsi.'], function () {
            Route::get('/', [SkripsiController::class, 'index'])->name('index');
            Route::post('/', [SkripsiController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [SkripsiController::class, 'preview'])->name('preview');
        });

        // Bagian Penelitian Matkul
        Route::group(['prefix' => 'penelitian-matkul', 'as' => 'penelitian-matkul.'], function () {
            Route::get('/', [PenelitianMatkulController::class, 'index'])->name('index');
            Route::post('/', [PenelitianMatkulController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [PenelitianMatkulController::class, 'preview'])->name('preview');
        });
    });

    // Bagian Surat Keterangan
    Route::group(['prefix' => 'surat-keterangan', 'as' => 'surat-keterangan.'], function () {
        // Bagian Aktif Kuliah
        Route::group(['prefix' => 'aktif-kuliah', 'as' => 'aktif-kuliah.'], function () {
            Route::get('/', [AktifKuliahController::class, 'index'])->name('index');
            Route::post('/', [AktifKuliahController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [AktifKuliahController::class, 'preview'])->name('preview');
        });

        // Bagian Bebas Sanksi Akademik
        Route::group(['prefix' => 'bebas-sanksi-akademik', 'as' => 'bebas-sanksi-akademik.'], function () {
            Route::get('/', [BebasSanksiAkademikController::class, 'index'])->name('index');
            Route::post('/', [BebasSanksiAkademikController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [BebasSanksiAkademikController::class, 'preview'])->name('preview');
        });
    });
});

require __DIR__.'/auth.php';
