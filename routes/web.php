<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\BantuanSekolahController;
use App\Http\Controllers\DataSekolahController;
use App\Http\Controllers\DataStatistikGuruController;
use App\Http\Controllers\DataStatistikSekolahController;
use App\Http\Controllers\FasilitasSekolahController;
use App\Http\Controllers\FilterAkreditasiController;
use App\Http\Controllers\FilterStatusBantuanController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\MonitoringGuruController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SekolahDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\USerKabalaiController;
use App\Http\Controllers\UserVerifikatorController;
use App\Http\Controllers\VerifikasiGuruController;
use App\Http\Controllers\VerifikasiProsesController;
use App\Http\Controllers\VerifikatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');




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
    Route::post('/sekolah/import', [SekolahController::class, 'import'])->name('sekolah.import');
    Route::put('/sekolah/{id}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::delete('/sekolah/{id}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');

    Route::get('/operator-sekolah', [UserController::class, 'index'])->name('operator-sekolah.index');
    Route::post('/operator-sekolah', [UserController::class, 'store'])->name('operator-sekolah.store');
    Route::put('/operator-sekolah/{id}', [UserController::class, 'update'])->name('operator-sekolah.update');
    Route::delete('/operator-sekolah/{id}', [UserController::class, 'destroy'])->name('operator-sekolah.destroy');

    Route::get('/user-manajemen', [ManajemenUserController::class, 'index'])->name('manajemen-user.index');
    Route::post('/user-manajemen', [ManajemenUserController::class, 'store'])->name('manajemen-user.store');
    Route::put('/user-manajemen/{id}', [ManajemenUserController::class, 'update'])->name('manajemen-user.update');
    Route::delete('/user-manajemen/{id}', [ManajemenUserController::class, 'destroy'])->name('manajemen-user.destroy');
});

// ROLE OPERATOR SEKOLAH
Route::middleware('auth', 'verified', 'Operator')->group(function () {

    Route::get('/dashboard-operator', [OperatorController::class, 'index'])->name('operator.dashboard');
    Route::get('/identitas-sekolah', [DataSekolahController::class, 'index_identitas'])->name('identitas-sekolah.index');
    Route::put('/identitas-sekolah', [DataSekolahController::class, 'update_identitas'])->name('identitas-sekolah.update');
    Route::get('/identitas-sosekbud', [DataSekolahController::class, 'index_sosekbud'])->name('sosekbud-sekolah.index');
    Route::put('/identitas-sosekbud', [DataSekolahController::class, 'update_sosekbud'])->name('sosekbud-sekolah.update');
    Route::get('/bantuan-sekolah', [BantuanSekolahController::class, 'index'])->name('bantuan-sekolah.index');
    Route::post('/bantuan-sekolah', [BantuanSekolahController::class, 'store'])->name('bantuan-sekolah.store');
    Route::delete('/bantuan-sekolah/{id}', [BantuanSekolahController::class, 'destroy'])->name('bantuan-sekolah.destroy');
    Route::get('/fasilitas', [FasilitasSekolahController::class, 'index'])->name('fasilitas-sekolah.index');
    Route::post('/fasilitas', [FasilitasSekolahController::class, 'store'])->name('fasilitas-sekolah.store');
    Route::delete('/fasilitas-lab/{id}', [FasilitasSekolahController::class, 'destroy_lab'])->name('fasilitas-sekolah-lab.destroy');

    Route::resource('data-guru', GuruController::class);
    Route::post('/sekolah/ajukan-verifikasi', [DataSekolahController::class, 'ajukanVerifikasi'])
    ->name('sekolah.ajukanVerifikasi');

});




// ROLE VERIFIKATOR

Route::middleware('auth', 'verified', 'Verifikator')->group(function(){
    Route::get('/dashboard-verifikator',[UserVerifikatorController::class, 'index'])->name('verifikator.dashboard');
    
    Route::resource('verifikasi-sekolah', VerifikasiProsesController::class);
    // Route::put('/verifikasi-sekolah/approve/{id}', [VerifikasiProsesController::class, 'approve'])->name('verifikasi-sekolah.approve');

    Route::resource('verifikasi-guru', VerifikasiGuruController::class);
    // Route::put('/verifikasi-guru/{id}', [VerifikasiGuruController::class, 'proses_verifikasi'])->name('verifikator.verifikasi.guru');
    Route::resource('monitoring-guru', MonitoringGuruController::class);

    
});


// ROLE KEPALA BTKI

Route::middleware('auth','verified','Kabalai')->group(function(){
    Route::get('kabalai-dashboard', [USerKabalaiController::class, 'index'])->name('kabalai.dashboard');
    Route::get('sort-akreditasi',[FilterAkreditasiController::class, 'sortAkreditasi'])->name('sekolah.sort.akreditasi');
    Route::get('api/akreditasi-data', [FilterAkreditasiController::class, 'getAkreditasiData'])->name('sekolah.getakreditasidata');
    Route::get('api/sekolah-detail', [FilterAkreditasiController::class, 'getSekolahDetail'])->name('sekolah.getdetail');

      // 1. Route untuk menampilkan halaman view
    Route::get('/', [FilterStatusBantuanController::class, 'sortBantuan'])->name('bantuan.index');
    // 2. Route API untuk mengambil data statistik Chart (Digunakan oleh JS: API_URL_CHART)
    Route::get('/datastatuspegawai-chart', [FilterStatusBantuanController::class, 'getBantuanData'])->name('bantuan.getdata');
    // 3. Route API untuk mengambil data detail sekolah (Digunakan oleh JS: API_URL_DETAIL)
    Route::get('/datastatuspegawai-detail', [FilterStatusBantuanController::class, 'getSekolahBantuanDetail'])->name('bantuan.getdetail');


});





require __DIR__ . '/auth.php';
