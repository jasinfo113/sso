<?php

use App\Http\Controllers\Account\AccountController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    });
});
