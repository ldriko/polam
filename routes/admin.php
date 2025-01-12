<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\AuthController;

// Panduan
use App\Http\Controllers\Admin\Guide\GuideController;

// Bagian Surat Pengantar
use App\Http\Controllers\Admin\SuratPengantar\PklController;
use App\Http\Controllers\Admin\SuratPengantar\SkripsiController;
use App\Http\Controllers\Admin\SuratPengantar\PenelitianMatkulController;

// Bagian Surat Keterangan
use App\Http\Controllers\Admin\SuratKeterangan\AktifKuliahController;
use App\Http\Controllers\Admin\SuratKeterangan\BebasSanksiAkademikController;

// Bagian Surat Rekomendasi
use App\Http\Controllers\Admin\SuratRekomendasi\BeasiswaController;
use App\Http\Controllers\Admin\SuratRekomendasi\MbkmController;
use App\Http\Controllers\Admin\SuratRekomendasi\NonMbkmController;

// Bagian Surat Lainnya
use App\Http\Controllers\Admin\SuratLainnya\TranskripController;
use App\Http\Controllers\Admin\SuratLainnya\CutiController;
use App\Http\Controllers\Admin\SuratLainnya\TransferController;
use App\Http\Controllers\Admin\SuratLainnya\PengunduranDiriController;

// Bagian Akun Admin
use App\Http\Controllers\Admin\Account\AccountController;

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

Route::get('login', [AuthController::class, 'index'])->name('auth.login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login.process');

Route::group(['middleware' => 'auth.employee'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Panduan
    Route::group(['prefix' => 'panduan', 'as' => 'guide.'], function () {
        Route::get('', [GuideController::class, 'index'])->name('index');
        Route::get('create', [GuideController::class, 'create'])->name('create');
        Route::get('edit/{guide}', [GuideController::class, 'edit'])->name('edit');
        Route::post('store', [GuideController::class, 'store'])->name('store');
        Route::post('update/{guide}', [GuideController::class, 'update'])->name('update');
        Route::get('destroy/{guide}', [GuideController::class, 'destroy'])->name('destroy');
    });

    // Bagian Surat Pengantar
    Route::group(['as' => 'surat-pengantar.', 'prefix' => 'surat-pengantar'], function() {
        // Bagian PKL
        Route::get('pkl', [PklController::class, 'index'])->name('pkl.index');
        Route::get('pkl/{submission}', [PklController::class, 'show'])->name('pkl.show');
        Route::post('pkl/{submission}', [PklController::class, 'update'])->name('pkl.update');

        // Bagian Skripsi
        Route::get('skripsi', [SkripsiController::class, 'index'])->name('skripsi.index');
        Route::get('skripsi/{submission}', [SkripsiController::class, 'show'])->name('skripsi.show');
        Route::post('skripsi/{submission}', [SkripsiController::class, 'update'])->name('skripsi.update');

        // Bagian Penelitian Matkul
        Route::get('penelitian-matkul', [PenelitianMatkulController::class, 'index'])->name('penelitian-matkul.index');
        Route::get('penelitian-matkul/{submission}', [PenelitianMatkulController::class, 'show'])->name('penelitian-matkul.show');
        Route::post('penelitian-matkul/{submission}', [PenelitianMatkulController::class, 'update'])->name('penelitian-matkul.update');
    });

    // Bagian Surat Keterangan
    Route::group(['prefix' => 'surat-keterangan', 'as' => 'surat-keterangan.'], function () {
        // Bagian Aktif Kuliah
        Route::get('aktif-kuliah', [AktifKuliahController::class, 'index'])->name('aktif-kuliah.index');
        Route::get('aktif-kuliah/{submission}', [AktifKuliahController::class, 'show'])->name('aktif-kuliah.show');
        Route::post('aktif-kuliah/{submission}', [AktifKuliahController::class, 'update'])->name('aktif-kuliah.update');

        // Bagian Aktif Kuliah
        Route::get('bebas-sanksi-akademik', [BebasSanksiAkademikController::class, 'index'])->name('bebas-sanksi-akademik.index');
        Route::get('bebas-sanksi-akademik/{submission}', [BebasSanksiAkademikController::class, 'show'])->name('bebas-sanksi-akademik.show');
        Route::post('bebas-sanksi-akademik/{submission}', [BebasSanksiAkademikController::class, 'update'])->name('bebas-sanksi-akademik.update');
    });

    // Bagian Surat Rekomendasi
    Route::group(['prefix' => 'surat-rekomendasi', 'as' => 'surat-rekomendasi.'], function () {
        // Bagian Beasiswa
        Route::get('beasiswa', [BeasiswaController::class, 'index'])->name('beasiswa.index');
        Route::get('beasiswa/{submission}', [BeasiswaController::class, 'show'])->name('beasiswa.show');
        Route::post('beasiswa/{submission}', [BeasiswaController::class, 'update'])->name('beasiswa.update');

        // Bagian MBKM
        Route::get('mbkm', [MbkmController::class, 'index'])->name('mbkm.index');
        Route::get('mbkm/{submission}', [MbkmController::class, 'show'])->name('mbkm.show');
        Route::post('mbkm/{submission}', [MbkmController::class, 'update'])->name('mbkm.update');

        // Bagian Non-MBKM
        Route::get('non-mbkm', [NonMbkmController::class, 'index'])->name('non-mbkm.index');
        Route::get('non-mbkm/{submission}', [NonMbkmController::class, 'show'])->name('non-mbkm.show');
        Route::post('non-mbkm/{submission}', [NonMbkmController::class, 'update'])->name('non-mbkm.update');
    });

    // Bagian Surat Lainnya
    Route::group(['prefix' => 'surat-lainnya', 'as' => 'surat-lainnya.'], function () {
        // Bagian Transkrip
        Route::get('transkrip', [TranskripController::class, 'index'])->name('transkrip.index');
        Route::get('transkrip/{submission}', [TranskripController::class, 'show'])->name('transkrip.show');
        Route::post('transkrip/{submission}', [TranskripController::class, 'update'])->name('transkrip.update');

        // Bagian Cuti
        Route::get('cuti', [CutiController::class, 'index'])->name('cuti.index');
        Route::get('cuti/{submission}', [CutiController::class, 'show'])->name('cuti.show');
        Route::post('cuti/{submission}', [CutiController::class, 'update'])->name('cuti.update');

        // Bagian Transfer
        Route::get('transfer', [TransferController::class, 'index'])->name('transfer.index');
        Route::get('transfer/{submission}', [TransferController::class, 'show'])->name('transfer.show');
        Route::post('transfer/{submission}', [TransferController::class, 'update'])->name('transfer.update');

        // Bagian Pengunduran Diri
        Route::get('pengunduran-diri', [PengunduranDiriController::class, 'index'])->name('pengunduran-diri.index');
        Route::get('pengunduran-diri/{submission}', [PengunduranDiriController::class, 'show'])->name('pengunduran-diri.show');
        Route::post('pengunduran-diri/{submission}', [PengunduranDiriController::class, 'update'])->name('pengunduran-diri.update');
    });

    // Bagian Akun Admin
    Route::group(['prefix' => 'akun', 'as' => 'account.'], function () {
        Route::get('', [AccountController::class, 'index'])->name('index');
        Route::get('create', [AccountController::class, 'create'])->name('create');
        Route::get('edit/{account}', [AccountController::class, 'edit'])->name('edit');
        Route::post('store', [AccountController::class, 'store'])->name('store');
        Route::post('update/{account}', [AccountController::class, 'update'])->name('update');
        Route::get('destroy/{account}', [AccountController::class, 'destroy'])->name('destroy');
    });
});
