<?php

use App\Http\Controllers\API\ApiLogDataController;
use App\Http\Controllers\API\ApiLoginController;
use App\Http\Controllers\API\ApiAlatMeterController;
use App\Http\Controllers\API\ApiPelangganController;
use App\Http\Controllers\API\ApiStafLapanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Berisi definisi rute API untuk aplikasi. Rute-rute ini di-load oleh
| RouteServiceProvider dan semuanya akan diberikan ke grup "api".
| Digunakan untuk komunikasi dengan aplikasi mobile Flutter.
|
*/

// Grup rute dengan awalan 'auth' untuk semua endpoint otentikasi dan data
Route::prefix('auth')->group(function () {
    // Route login yang dapat diakses tanpa autentikasi
    Route::post('/login', [ApiLoginController::class, 'login'])->middleware('api');
    // Route login khusus untuk staf lapangan
    Route::post('/staff-login', [ApiStafLapanganController::class, 'login'])->middleware('api');
    // Grup rute yang memerlukan autentikasi Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('pelanggan', ApiPelangganController::class);
        Route::apiResource('alat-meter', ApiAlatMeterController::class);
        Route::apiResource('staff', ApiStafLapanganController::class);
        Route::apiResource('log-data', ApiLogDataController::class);
        // Endpoint untuk get profil staf lapangan
        Route::get('/user-profile', [ApiLoginController::class, 'userProfile']);
        // Pencarian data pelanggan
        Route::post('pelanggan/search', [ApiPelangganController::class, 'search']);
        // Endpoint khusus untuk staf lapangan mengirimkan data hasil pengecekan meter
        Route::post('staff/submit-data', [ApiStafLapanganController::class, 'submitData']);
        // Endpoint untuk update password untuk staf lapangan
        Route::post('/update-password', [ApiStafLapanganController::class, 'updatePassword']);
        // Endpoint untuk logout dan mendapatkan profil pengguna
        Route::post('/logout', [ApiLoginController::class, 'logout']);
    });
});
