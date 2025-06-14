<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AlatMeterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogDataController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StafLapanganController;
use App\Http\Controllers\WilayahController;
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

// Auth
// Auth::routes();

// Login
Route::controller(LoginController::class)->group(function(){

    Route::get('/', 'index')->name('login');

    Route::post('logout', 'logout')->name('logout');

    Route::post('validate_login', 'validate_login')->name('sample.validate_login');

});

// dashboard harus login
Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // Log Data
    Route::resource('/dashboard/logdata', LogDataController::class);
    Route::get('/pelanggan/search', [PelangganController::class, 'search'])->name('pelanggan.search');
    // Pelanggan
    Route::resource('/dashboard/pelanggan', PelangganController::class);
    // Merk Meter
    Route::resource('/dashboard/alatmeter', AlatMeterController::class);
    // staff/user
    Route::resource('/dashboard/staflapangan', StafLapanganController::class);
    Route::get('/staflapangan/rekap', [StafLapanganController::class, 'rekap'])->name('staflapangan.rekap');
    Route::get('/staflapangan/detailrekap/{nip}', [StafLapanganController::class, 'detailrekap'])->name('staflapangan.detailrekap');
    // Profil
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    // Ubah Password
    Route::get('/profile/ubah-password', [DashboardController::class, 'ubahpassword'])->name('ubahPassword');
    Route::post('/ubah-password', [DashboardController::class, 'changepassword'])->name('profile.ubahPassword');
    // Get Wilayah
    Route::get('/get-wilayah/{kode}', [WilayahController::class, 'getWilayahByKode']);
});
