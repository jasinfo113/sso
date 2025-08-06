<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\UnitController;
use App\Http\Controllers\Api\V1\MasterController;

Route::middleware('valid_access')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index']);
        Route::get('/token', [AccountController::class, 'token']);
    });

    Route::post('unit/status', [UnitController::class, 'status']);
});

Route::middleware('api_client')->group(function () {
    Route::prefix('master')->group(function () {
        Route::get('/provinsi', [MasterController::class, 'provinsi']);
        Route::get('/kota', [MasterController::class, 'kota']);
        Route::get('/kecamatan', [MasterController::class, 'kecamatan']);
        Route::get('/kelurahan', [MasterController::class, 'kelurahan']);
        Route::get('/wilayah', [MasterController::class, 'wilayah']);
        Route::get('/sektor', [MasterController::class, 'sektor']);
        Route::get('/pos', [MasterController::class, 'pos']);
        Route::get('/lokasi', [MasterController::class, 'lokasi']);
        Route::get('/jabatan', [MasterController::class, 'jabatan']);
        Route::get('/penugasan', [MasterController::class, 'penugasan']);
        Route::get('/penempatan', [MasterController::class, 'penempatan']);
        Route::get('/unit', [MasterController::class, 'unit']);
        Route::get('/unit/{no_polisi}', [MasterController::class, 'unit_detail']);
        Route::get('/unit_kategori', [MasterController::class, 'unit_kategori']);
        Route::get('/unit_jenis', [MasterController::class, 'unit_jenis']);
        Route::get('/pdo_kategori', [MasterController::class, 'pdo_kategori']);
        Route::get('/pdo_jenis', [MasterController::class, 'pdo_jenis']);
    });
    Route::post('/auth-client', [AuthController::class, 'client_auth']);
});
