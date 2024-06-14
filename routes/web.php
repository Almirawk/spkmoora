<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\PendonorController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\DetailRiwayatController;
use App\Models\Pemeriksaan;
use App\Http\Controllers\RiwayatPemeriksaanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Auth::routes();




// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', [RiwayatPemeriksaanController::class, 'index'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('kriteria')->group(function () {
        Route::get('', [KriteriaController::class, 'index'])->name('kriteria');
        Route::get('insert', [KriteriaController::class, 'add'])->name('kriteria.insert');
        Route::post('insert', [KriteriaController::class, 'insert'])->name('kriteria.add.insert');
        Route::get('edit/{id}', [KriteriaController::class, 'edit'])->name('kriteria.edit');
        Route::post('update/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::get('delete/{id}', [KriteriaController::class, 'delete'])->name('kriteria.delete');
    });

    Route::prefix('pendonor')->group(function () {
        Route::get('', [PendonorController::class, 'index'])->name('pendonor');
        Route::get('insert', [PendonorController::class, 'add'])->name('pendonor.insert');
        Route::post('insert', [PendonorController::class, 'insert'])->name('pendonor.add.insert');
        Route::get('edit/{id}', [PendonorController::class, 'edit'])->name('pendonor.edit');
        Route::post('update/{id}', [PendonorController::class, 'update'])->name('pendonor.update');
        Route::get('delete/{id}', [PendonorController::class, 'delete'])->name('pendonor.delete');
    });
 
    Route::prefix('pemeriksaan')->group(function () {
        Route::get('', [PemeriksaanController::class, 'index'])->name('pemeriksaan');
        Route::get('insert', [PemeriksaanController::class, 'add'])->name('pemeriksaan.insert');
        Route::post('insert', [PemeriksaanController::class, 'insert'])->name('pemeriksaan.add.insert');
        Route::get('edit/{id}', [PemeriksaanController::class, 'edit'])->name('pemeriksaan.edit');
        Route::post('update/{id}', [PemeriksaanController::class, 'update'])->name('pemeriksaan.update');
        Route::post('delete/{id}', [PemeriksaanController::class, 'delete'])->name('pemeriksaan.delete');
        Route::post('/nilai/set', [PemeriksaanController::class, 'setNilai'])->name('nilai.set');
        Route::post('/nilai/update', [PemeriksaanController::class, 'updateNilai'])->name('nilai.update');
        // Route::delete('/pendonor/{id}', [PendonorController::class, 'destroy'])->name('pendonor.destroy');

    });

    Route::delete('/pemeriksaan/{pendonor}', [PemeriksaanController::class, 'destroy'])->name('pemeriksaan.destroy');


    Route::prefix('hasil')->group(function () {
        Route::get('', [HasilController::class, 'index'])->name('hasil');
        Route::post('/hasil/simpan', [HasilController::class,'simpan'])->name('hasil.simpan');
        Route::get('/riwayat', [HasilController::class,'riwayat'])->name('riwayat');
        Route::get('/riwayat/pdf/{datetime}', [HasilController::class, 'generateRiwayatPdf'])->name('riwayat.pdf');
        Route::get('/riwayat/detail/{datetime}', [HasilController::class, 'detailRiwayat'])->name('riwayat.detail');
        Route::get('riwayat/{id}', [DetailRiwayatController::class, 'show'])->name('riwayat.show');

    });

});

