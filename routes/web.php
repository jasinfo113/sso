<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::fallback(function () {
//     return redirect('/');
// });

Route::get('/', function () {
    if (Auth::guard('web')->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth/login');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    echo 'config was successfully cleared!';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    echo 'storage was successfully linked!';
});

require __DIR__ . '/web/web_auth.php';
require __DIR__ . '/web/web_general.php';
require __DIR__ . '/web/web_admin.php';
require __DIR__ . '/web/web_account.php';
