<?php

// Controller untuk manajemen halaman
use App\Http\Controllers\HalamanAdminController;
use App\Http\Controllers\HalamanBKController;


// Controller untuk Fitur CRUD pada aplikasi
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;


use Illuminate\Support\Facades\Route;

// Route khusus halaman login
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/beranda', [HalamanAdminController::class, 'beranda']);
    Route::get('/data-absensi', [HalamanAdminController::class, 'data_absensi'])->name('data_absensi');
    Route::get('/data-absensi/filter', [HalamanAdminController::class, 'filter_data_absensi'])->name('admin.data_absensi.filter');

    //Import Excel
    Route::post('/data-guru/import', [GuruController::class, 'import_excel'])->name('admin.data_guru.import_excel');
    Route::post('/data-siswa/import', [SiswaController::class, 'import_excel'])->name('admin.data_siswa.import_excel');

    // Route yang menangani fungsi CRUD
    Route::resource('/data-guru', GuruController::class);
    Route::resource('/data-siswa', SiswaController::class);
    Route::resource('/data-kelas', KelasController::class);
    Route::resource('/data-user', UserController::class);
});

Route::group(['middleware' => 'auth', 'prefix' => 'guru'], function () {
    Route::resource('/absensi', AbsensiController::class)->except('show', 'edit', 'destroy');
    Route::get('/data-absensi', [HalamanAdminController::class, 'data_absensi'])->name('guru.data_absensi');
    Route::get('/data-absensi/filter', [HalamanAdminController::class, 'filter_data_absensi'])->name('guru.data_absensi.filter');
});

Route::group(['middleware' => 'auth', 'prefix' => 'bk'], function () {
    Route::get('/beranda', [HalamanBKController::class, 'index'])->name('bk.beranda');
    Route::get('/data-absensi', [HalamanAdminController::class, 'data_absensi'])->name('bk.data_absensi');
    Route::get('/data-absensi/filter', [HalamanAdminController::class, 'filter_data_absensi'])->name('bk.data_absensi.filter');
});
