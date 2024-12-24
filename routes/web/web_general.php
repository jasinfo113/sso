<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth')->group(function () {
    Route::prefix('general')->group(function () {
        Route::get('/test', function (Request $request) {
            $_email = [
                'subject' => 'Selamat Datang di SOBAT Damkar',
                'title' => 'Selamat Datang di SOBAT Damkar',
                'content' => 'email.auth.registration',
                'url' => 'https://pemadam.jakarta.go.id/',
            ];
            return view('email.layout', $_email);
            $request = app(\App\Classes\EmailController::class)->send('ardian.jasinfo@gmail.com', $_email);
            echo json_encode($request);
        })->name('email');
    });
});
