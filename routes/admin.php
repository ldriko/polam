<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\AuthController;

// Bagian Surat Pengantar
use App\Http\Controllers\Admin\SuratPengantar\PklController;
use App\Http\Controllers\Admin\SuratPengantar\SkripsiController;
use App\Http\Controllers\Admin\SuratPengantar\PenelitianMatkulController;

// Bagian Surat Keterangan
use App\Http\Controllers\Admin\SuratKeterangan\AktifKuliahController;
use App\Http\Controllers\Admin\SuratKeterangan\BebasSanksiAkademikController;

// Bagian Surat Lainnya
use App\Http\Controllers\Admin\SuratLainnya\TranskripController;
use App\Http\Controllers\Admin\SuratLainnya\CutiController;
use App\Http\Controllers\Admin\SuratLainnya\TransferController;
use App\Http\Controllers\Admin\SuratLainnya\PengunduranDiriController;

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

    // Bagian surat keterangan
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
});
