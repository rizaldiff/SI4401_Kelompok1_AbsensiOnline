<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/profile', [DashboardController::class, 'index'])->name('profile');
    Route::get('/setting', [DashboardController::class, 'index'])->name('setting');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensiku', [UserController::class, 'absensiku'])->name('absensiku');
    Route::get('/datapegawai', [DashboardController::class, 'dataPegawai'])->name('datapegawai');
    Route::get('/absensi', [DashboardController::class, 'absensi'])->name('absensi');
    Route::get('/settingapp', [DashboardController::class, 'index'])->name('settingapp');
    Route::get('/export', [DocsController::class, 'export'])->name('export');
    Route::post('/export', [DocsController::class, 'exportAbsensi']);

    Route::prefix('ajax')->group(function () {
        Route::post('absenajax', [AjaxController::class, 'absenajax'])->name('ajax.absenajax');
        Route::get('pegawai_terlambat_dt', [AjaxController::class, 'getPegawaiTerlambatDt'])->name('ajax.getPegawaiTerlambatDt');
        Route::get('pegawai_masuk_dt', [AjaxController::class, 'getPegawaiMasukDt'])->name('ajax.getPegawaiMasukDt');
        Route::get('absensiku_dt', [AjaxController::class, 'getAbsensikuDt'])->name('ajax.getAbsensikuDt');
        Route::post('view_absensi', [AjaxController::class, 'getDetailAbsensi'])->name('ajax.getDetailAbsensi');
        Route::get('pegawai_dt', [AjaxController::class, 'getPegawaiDt'])->name('ajax.getPegawaiDt');
        Route::post('view_pegawai', [AjaxController::class, 'getDetailPegawai'])->name('ajax.getDetailPegawai');
        Route::post('act_pegawai', [AjaxController::class, 'actPegawai'])->name('ajax.actPegawai');
        Route::post('edit_pegawai', [AjaxController::class, 'editPegawai'])->name('ajax.editPegawai');
        Route::post('update_pegawai', [AjaxController::class, 'updatePegawai'])->name('ajax.updatePegawai');
        Route::post('store_pegawai', [AjaxController::class, 'storePegawai'])->name('ajax.storePegawai');
        Route::post('delete_pegawai', [AjaxController::class, 'deletePegawai'])->name('ajax.deletePegawai');
        Route::get('absensi', [AjaxController::class, 'absensi'])->name('ajax.absensi');
        Route::get('cetak', [DocsController::class, 'cetak'])->name('ajax.cetak');
        Route::post('hapus_absensi', [AjaxController::class, 'hapusAbsensi'])->name('ajax.hapusAbsensi');
        Route::post('hapus_semua_absensi', [AjaxController::class, 'hapusSemuaAbsensi'])->name('ajax.hapusSemuaAbsensi');
    });
});
