<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;

class GeneralController extends Controller
{

    public function captcha()
    {
        return response()->json(['status' => TRUE, 'message' => 'Captcha berhasil di perbarui', 'results' => captcha_img()]);
    }
}
