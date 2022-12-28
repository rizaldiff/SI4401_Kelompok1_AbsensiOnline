<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/datapegawai', [DashboardController::class, 'index'])->name('datapegawai');
    Route::get('/absensi', [DashboardController::class, 'index'])->name('absensi');
    Route::get('/settingapp', [DashboardController::class, 'index'])->name('settingapp');

    Route::prefix('ajax')->group(function () {
        Route::post('absenajax', [AjaxController::class, 'absenajax'])->name('ajax.absenajax');
        Route::get('pegawai_terlambat_dt', [AjaxController::class, 'getPegawaiTerlambatDt'])->name('ajax.getPegawaiTerlambatDt');
        Route::get('pegawai_masuk_dt', [AjaxController::class, 'getPegawaiMasukDt'])->name('ajax.getPegawaiMasukDt');
        Route::get('absensiku_dt', [AjaxController::class, 'getAbsensikuDt'])->name('ajax.getAbsensikuDt');
        Route::post('view_absensi', [AjaxController::class, 'getDetailAbsensi'])->name('ajax.getDetailAbsensi');
    });
});
