<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\MasterController;

Route::middleware('valid_access')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index']);
        Route::get('/token', [AccountController::class, 'token']);
    });

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
    });
});
