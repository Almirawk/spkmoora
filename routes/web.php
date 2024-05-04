<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\PendonorController;
use App\Http\Controllers\KriteriaController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::controller(KriteriaController::class)->prefix('kriteria')->group(function() {
    Route::get('', 'index')->name('kriteria');
    Route::get('insert', 'add')->name('kriteria.insert');
    Route::post('insert', 'insert')->name('kriteria.add.insert');
    Route::get('edit/{id}', 'edit')->name('kriteria.edit');
    Route::post('update/{id}', 'update')->name('kriteria.update');
    Route::get('delete/{id}', 'delete')->name('kriteria.delete');
});

Route::controller(PendonorController::class)->prefix('pendonor')->group(function() {
    Route::get('', 'index')->name('pendonor');
    Route::get('insert', 'add')->name('pendonor.insert');
    Route::post('insert', 'insert')->name('pendonor.add.insert');
    Route::get('edit/{id}', 'edit')->name('pendonor.edit');
    Route::post('update/{id}', 'update')->name('pendonor.update');
    Route::get('delete/{id}', 'delete')->name('pendonor.delete');
});

Route::controller(HasilController::class)->prefix('hasil')->group(function() {
    Route::get('', 'index')->name('hasil');
    Route::get('/hasil/pdf', 'HasilController@generatePdf')->name('hasil.pdf');
});
