<?php

use App\Http\Controllers\ProfileController as Profile2;
use Illuminate\Support\Facades\Route;

// Controller Profile
use App\Http\Controllers\Website\Profile\ProfileController;

// Controller Ganti Password
use App\Http\Controllers\Website\ChangePassword\ChangePasswordController;

// Controller Surat Pengantar
use App\Http\Controllers\Website\SuratPengantar\PklController;
use App\Http\Controllers\Website\SuratPengantar\SkripsiController;
use App\Http\Controllers\Website\SuratPengantar\PenelitianMatkulController;

// Controller Surat Keterangan
use App\Http\Controllers\Website\SuratKeterangan\AktifKuliahController;
use App\Http\Controllers\Website\SuratKeterangan\BebasSanksiAkademikController;

// Controller Surat Rekomendasi
use App\Http\Controllers\Website\SuratRekomendasi\BeasiswaController;
use App\Http\Controllers\Website\SuratRekomendasi\MbkmController;
use App\Http\Controllers\Website\SuratRekomendasi\NonMbkmController;

// Controller Surat Lainnya
use App\Http\Controllers\Website\SuratLainnya\TranskripController;
use App\Http\Controllers\Website\SuratLainnya\CutiController;
use App\Http\Controllers\Website\SuratLainnya\TransferController;
use App\Http\Controllers\Website\SuratLainnya\PengunduranDiriController;

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
    Route::get('/profile2', [Profile2::class, 'edit'])->name('profile.edit');
    Route::patch('/profile2', [Profile2::class, 'update'])->name('profile.update');
    Route::delete('/profile2', [Profile2::class, 'destroy'])->name('profile.destroy');

    // Bagian Profil Mahasiswa
    Route::group(['prefix' => 'profil', 'as' => 'profile.'], function () {
        Route::get('', [ProfileController::class, 'index'])->name('index');
        Route::post('', [ProfileController::class, 'update'])->name('update');

        // Bagian Ganti Password
        Route::group(['prefix' => 'ganti-password', 'as' => 'change-password.'], function () {
            Route::get('', [ChangePasswordController::class, 'index'])->name('index');
            Route::post('', [ChangePasswordController::class, 'update'])->name('update');
        });
    });

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

    // Bagian Surat Rekomendasi
    Route::group(['prefix' => 'surat-rekomendasi', 'as' => 'surat-rekomendasi.'], function () {
        // Bagian Beasiswa
        Route::group(['prefix' => 'beasiswa', 'as' => 'beasiswa.'], function () {
            Route::get('/', [BeasiswaController::class, 'index'])->name('index');
            Route::post('/', [BeasiswaController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [BeasiswaController::class, 'preview'])->name('preview');
        });

        // Bagian MBKM
        Route::group(['prefix' => 'mbkm', 'as' => 'mbkm.'], function () {
            Route::get('/', [MbkmController::class, 'index'])->name('index');
            Route::post('/', [MbkmController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [MbkmController::class, 'preview'])->name('preview');
        });

        // Bagian Non-MBKM
        Route::group(['prefix' => 'non-mbkm', 'as' => 'non-mbkm.'], function () {
            Route::get('/', [NonMbkmController::class, 'index'])->name('index');
            Route::post('/', [NonMbkmController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [NonMbkmController::class, 'preview'])->name('preview');
        });
    });

    // Bagian Surat Lainnya
    Route::group(['prefix' => 'surat-lainnya', 'as' => 'surat-lainnya.'], function () {
        // Bagian Transkrip
        Route::group(['prefix' => 'transkrip', 'as' => 'transkrip.'], function () {
            Route::get('/', [TranskripController::class, 'index'])->name('index');
            Route::post('/', [TranskripController::class, 'store'])->name('store');
        });

        // Bagian Cuti
        Route::group(['prefix' => 'cuti', 'as' => 'cuti.'], function () {
            Route::get('/', [CutiController::class, 'index'])->name('index');
            Route::post('/', [CutiController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [CutiController::class, 'preview'])->name('preview');
        });

        // Bagian Transfer
        Route::group(['prefix' => 'transfer', 'as' => 'transfer.'], function () {
            Route::get('/', [TransferController::class, 'index'])->name('index');
            Route::post('/', [TransferController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [TransferController::class, 'preview'])->name('preview');
        });

        // Bagian Pengunduran Diri
        Route::group(['prefix' => 'pengunduran-diri', 'as' => 'pengunduran-diri.'], function () {
            Route::get('/', [PengunduranDiriController::class, 'index'])->name('index');
            Route::post('/', [PengunduranDiriController::class, 'store'])->name('store');
            Route::get('/preview/{submission}', [PengunduranDiriController::class, 'preview'])->name('preview');
        });
    });
});

require __DIR__.'/auth.php';
