<?php

namespace App\Classes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralEmail;
use Illuminate\Database\Query\JoinClause;

class EmailController extends Controller
{

    public function send($recipients, $data)
    {
        $status = false;
        $message = __('response.no_process');
        try {
            Mail::to($recipients)->send(new GeneralEmail($data));
            $status = true;
            $message = "Email sent!";
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                $message = $e->getMessage();
            } else {
                $message = "Failed to send email!";
            }
        }
        $json["status"] = $status;
        $json["message"] = $message;
        return json_decode(json_encode($json));
    }

    public function sendNow($recipients, $data)
    {
        $status = false;
        $message = __('response.no_process');
        try {
            Mail::to($recipients)->sendNow(new GeneralEmail($data));
            $status = true;
            $message = "Email sent!";
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                $message = $e->getMessage();
            } else {
                $message = "Failed to send email!";
            }
        }
        $json["status"] = $status;
        $json["message"] = $message;
        return json_decode(json_encode($json));
    }

    public function queue($recipients, $data)
    {
        $status = false;
        $message = __('response.no_process');
        try {
            Mail::to($recipients)->queue(new GeneralEmail($data));
            $status = true;
            $message = "Email sent!";
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                $message = $e->getMessage();
            } else {
                $message = "Failed to send email!";
            }
        }
        $json["status"] = $status;
        $json["message"] = $message;
        return json_decode(json_encode($json));
    }

    public function birthday()
    {
        $query = DB::connection("default")->table(config('database.connections.central.database') . ".pegawai AS p");
        $query->selectRaw("p.nip_nik,p.email,p.nama_pegawai,p.gelar_depan,p.gelar_belakang,p.jenis_kelamin");
        $query->selectRaw("FLOOR(DATEDIFF(CURDATE(),p.tanggal_lahir) / 365) AS usia");
        $query->leftJoin(config('database.connections.default.database') . ".birthday_history AS bh", function (JoinClause $join) {
            $join->on("p.nip_nik", "bh.ref_id")
                ->whereRaw("bh.ref = 'pegawai'");
        });
        $query->whereRaw("RIGHT(p.tanggal_lahir,5) = RIGHT(CURDATE(),5) AND p.tanggal_lahir IS NOT NULL AND p.email IS NOT NULL AND p.email != '' AND p.is_deleted = 0");
        $query->whereRaw("bh.id IS NULL");
        if ($query->count()) {
            foreach ($query->get() as $row) {
                $name = ($row->jenis_kelamin == "L" ? "Bapak " : ($row->jenis_kelamin == "P" ? "Ibu " : "")) . ($row->gelar_depan ? $row->gelar_depan . " " : "") . $row->nama_pegawai . ($row->gelar_belakang ? " " . $row->gelar_belakang : "");
                $_email = [
                    'subject' => "Selamat Ulang Tahun " . $name,
                    'title' => "Selamat Ulang Tahun ke " . $row->usia . " " . $name,
                    'content' => 'email.pegawai.birthday',
                ];
                app(\App\Classes\EmailController::class)->queue($row->email, $_email);
            }
        }
    }
}
