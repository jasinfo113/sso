<?php

use App\Http\Controllers\Common\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::fallback(function () {
//     return redirect('/');
// });

Route::get('/', function (Request $request) {
    if (Auth::guard('web')->check()) {
        if ($request->has('client_id')) {
            $req = app(\App\Http\Controllers\Admin\DashboardController::class)->app_login($request);
            $response = $req->getData();
            if ($response->status) {
                return redirect($response->url);
            }
        }
        return redirect()->route('dashboard');
    }
    $data['client_id'] = ($request->has('client_id') ? $request->string('client_id') : NULL);
    return view('auth/login', $data);
});

Route::post('captcha-refresh', [GeneralController::class, 'captcha'])->name('captcha.refresh');

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
