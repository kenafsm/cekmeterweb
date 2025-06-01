<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Pelanggan
Route::apiResource('/pelanggan', App\Http\Controllers\API\PelangganController::class);

// Merk Meter
Route::apiResource('/merk-meter', App\Http\Controllers\API\MerkMeterController::class);

// Staff
Route::apiResource('/staff', App\Http\Controllers\API\StaffController::class);
