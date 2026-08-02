<?php
// Controller untuk Fitur CRUD pada aplikasi
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;


use Illuminate\Support\Facades\Route;

// Route khusus halaman login
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'checkrole:Admin'], 'prefix' => 'admin'], function () {
    Route::get('/beranda', [DashboardController::class, 'beranda_admin'])->name('admin.beranda');
    Route::get('/data-absensi', [DashboardController::class, 'data_absensi'])->name('admin.data_absensi');
    Route::get('/rekapitulasi-absensi', [DashboardController::class, 'rekapitulasi_absensi'])->name('admin.rekapitulasi');
    Route::get('/download/{kelas}', [KelasController::class, 'download_qr'])->name('admin.data_kelas.download_qr');

    //Import Excel
    Route::post('/data-guru/import', [GuruController::class, 'import_excel'])->name('admin.data_guru.import_excel');
    Route::post('/data-siswa/import', [SiswaController::class, 'import_excel'])->name('admin.data_siswa.import_excel');

    // Route yang menangani fungsi CRUD
    Route::resource('/data-guru', GuruController::class)->parameters(['data-guru' => 'guru']);
    Route::patch('/data-guru/{guru}/status', [GuruController::class, 'update_status'])->name('data_guru.update_status');
    Route::resource('/data-siswa', SiswaController::class)->parameters(['data-siswa' => 'siswa']);
    Route::resource('/data-kelas', KelasController::class)->parameters(['data-kelas' => 'kelas'])->except(['destroy']);
    Route::resource('/data-user', UserController::class)->parameters(['data-user' => 'user']);
});

Route::group(['middleware' => ['auth', 'checkrole:Guru'], 'prefix' => 'guru'], function () {
    Route::resource('/absensi', AbsensiController::class)->except('show', 'destroy');
    Route::get('/data-absensi', [AbsensiController::class, 'data_absensi'])->name('guru.data_absensi');
    Route::get('/data-absensi/siswa/{siswa_id}', [AbsensiController::class, 'detailSiswa'])->name('data_absensi.detail');
});

Route::group(['middleware' => ['auth', 'checkrole:BK'], 'prefix' => 'bk'], function () {
    Route::get('/beranda', [DashboardController::class, 'beranda_bk'])->name('bk.beranda');
    Route::get('/data-absensi', [DashboardController::class, 'data_absensi'])->name('bk.data_absensi');
    Route::get('/rekapitulasi-absensi', [DashboardController::class, 'rekapitulasi_absensi'])->name('bk.rekapitulasi');
});
