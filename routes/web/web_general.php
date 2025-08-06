<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('general')->group(function () {
    Route::get('/test', function (Request $request) {

        $ip_address = $request->ip();
        $user_agent = $request->userAgent();

        #==REGISTER==#
        $_email = [
            'subject' => 'Selamat Datang di Sistem Informasi Damkar',
            'title' => 'Selamat Datang di Sistem Informasi Damkar',
            'content' => 'email.auth.registration',
            'url' => 'https://pemadam.jakarta.go.id/',
        ];
        // return view('email.layout', $_email);

        #==VERIFICATION==#
        $_email = [
            'subject' => 'Email Anda Telah Terverifikasi',
            'title' => 'Terima kasih!',
            'content' => 'email.auth.account_verification',
            'url' => 'https://pemadam.jakarta.go.id/',
        ];
        // return view('email.layout', $_email);

        #==LOGIN==#
        $_email = [
            'subject' => 'Informasi Login',
            'title' => 'Informasi Login',
            'content' => 'email.auth.login',
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
        ];
        // return view('email.layout', $_email);

        #==FORGOT==#
        $recovery_id = 1;
        $code = Str::random(35);
        $expired_at = now()->addMinute(30);
        $url = "https://pemadam.jakarta.go.id/sso/reset-password/" . md5($recovery_id . $code);
        $_email = [
            'subject' => 'Reset Password',
            'title' => 'Reset Password',
            'content' => 'email.auth.reset_password',
            'expired_at' => $expired_at->format('d F Y H:i'),
            'url' => $url,
        ];
        // return view('email.layout', $_email);

        #==PASSWORD==#
        $_email = [
            'subject' => 'Informasi Perubahan Password',
            'title' => 'Informasi Perubahan Password',
            'content' => 'email.auth.change_password',
        ];
        // return view('email.layout', $_email);

        #==PHONE==#
        $_email = [
            'subject' => 'Informasi Perubahan Nomor Telepon',
            'title' => 'Informasi Perubahan Nomor Telepon',
            'content' => 'email.auth.change_phone',
            'phone' => '628123456789',
        ];
        // return view('email.layout', $_email);

        #==EMAIL==#
        $_email = [
            'subject' => 'Informasi Perubahan Email',
            'title' => 'Informasi Perubahan Email',
            'content' => 'email.auth.change_email',
            'email' => 'john@gmail.com',
        ];
        // return view('email.layout', $_email);

        #==BIRTHDAY==#
        $_email = [
            'subject' => "Selamat Ulang Tahun",
            'title' => "Selamat Ulang Tahun",
            'nama' => 'John',
            'usia' => '24',
            'content' => 'email.pegawai.birthday',
        ];
        return view('email.layout', $_email);

        $request = app(\App\Classes\EmailController::class)->send('ardian.jasinfo@gmail.com', $_email);
        echo json_encode($request);
    })->name('email');
});
