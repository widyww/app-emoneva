<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ROLE ADMINISTRATOR
Route::middleware('auth', 'verified', 'Administrator')->group(function () {

    Route::get('/dashboard', [AdministratorController::class, 'index'])->name('dashboard');

    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::post('/kecamatan', [KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::put('/kecamatan/{id}', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{id}', [KecamatanController::class, 'destroy'])->name('kecamatan.destroy');

    Route::get('/kota', [KotaController::class, 'index'])->name('kota.index');
    Route::post('/kota', [KotaController::class, 'store'])->name('kota.store');
    Route::put('/kota/{id}', [KotaController::class, 'update'])->name('kota.update');
    Route::delete('/kota/{id}', [KotaController::class, 'destroy'])->name('kota.destroy');

    Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::put('/periode/{id}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/periode/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
    Route::put('/periode/{id}/set-aktif', [PeriodeController::class, 'setAktif'])->name('periode.setAktif');

    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::post('/sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::put('/sekolah/{id}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::delete('/sekolah/{id}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');





});

// ROLE OPERATOR SEKOLAH





// ROLE VERIFIKATOR


// ROLE KEPALA BTKI







require __DIR__ . '/auth.php';
