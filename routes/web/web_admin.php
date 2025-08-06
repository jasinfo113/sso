<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('valid_access')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.view');
        })->name('dashboard');
        Route::post('/app/data', [DashboardController::class, 'app_data'])->name('app.data');
        Route::post('/app/login', [DashboardController::class, 'app_login'])->name('app.login');
    });
});
