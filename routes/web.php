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

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/beranda', [DashboardController::class, 'beranda_admin']);
    Route::get('/data-absensi', [DashboardController::class, 'data_absensi'])->name('data_absensi');
    Route::get('/data-absensi/filter', [DashboardController::class, 'filter_data_absensi'])->name('admin.data_absensi.filter');

    //Import Excel
    Route::post('/data-guru/import', [GuruController::class, 'import_excel'])->name('admin.data_guru.import_excel');
    Route::post('/data-siswa/import', [SiswaController::class, 'import_excel'])->name('admin.data_siswa.import_excel');

    // Route yang menangani fungsi CRUD
    Route::resource('/data-guru', GuruController::class)->parameters(['data-guru' => 'guru']);
    Route::resource('/data-siswa', SiswaController::class)->parameters(['data-siswa' => 'siswa']);
    Route::resource('/data-kelas', KelasController::class)->parameters(['data-kelas' => 'kelas']);
    Route::resource('/data-user', UserController::class)->parameters(['data-user' => 'user']);
});

Route::group(['middleware' => 'auth', 'prefix' => 'guru'], function () {
    // Route::resource('/absensi', AbsensiController::class)->except('show', 'destroy');
    // // Route::get('/absensi/{slug_kelas}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    // Route::get('/absensi/{id_kelas}', [AbsensiController::class, 'index'])->name('absensi.index');
    // Temporary route
    Route::get('/absensi/{id_kelas?}', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create/{id_kelas}', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id_kelas}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{id_kelas}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::get('/data-absensi', [DashboardController::class, 'data_absensi'])->name('guru.data_absensi');
    Route::get('/data-absensi/filter', [DashboardController::class, 'filter_data_absensi'])->name('guru.data_absensi.filter');
});

Route::group(['middleware' => 'auth', 'prefix' => 'bk'], function () {
    Route::get('/beranda', [DashboardController::class, 'beranda_bk'])->name('bk.beranda');
    Route::get('/data-absensi', [DashboardController::class, 'data_absensi'])->name('bk.data_absensi');
    Route::get('/data-absensi/filter', [DashboardController::class, 'filter_data_absensi'])->name('bk.data_absensi.filter');
});
