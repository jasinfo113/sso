<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{


    public function profile(Request $request)
    {
        $user = $request->user();
        $query = DB::connection("central")->table("pegawai AS p");
        $query->leftJoin("m_area_kelurahan AS pkkl", "p.id_kelurahan_ktp", "pkkl.id_kelurahan");
        $query->leftJoin("m_area_kecamatan AS pkkc", "pkkl.id_kecamatan", "pkkc.id_kecamatan");
        $query->leftJoin("m_area_kota AS pkkt", "pkkc.id_kota", "pkkt.id_kota");
        $query->leftJoin("m_area_provinsi AS pkkp", "pkkt.id_provinsi", "pkkp.id_provinsi");
        $query->leftJoin("m_area_kelurahan AS pdkl", "p.id_kelurahan_domisili", "pdkl.id_kelurahan");
        $query->leftJoin("m_area_kecamatan AS pdkc", "pdkl.id_kecamatan", "pdkc.id_kecamatan");
        $query->leftJoin("m_area_kota AS pdkt", "pdkc.id_kota", "pdkt.id_kota");
        $query->leftJoin("m_area_provinsi AS pdkp", "pdkt.id_provinsi", "pdkp.id_provinsi");
        $query->leftJoin("m_pegawai_jenis AS pj", "p.id_jenis_pegawai", "pj.id_jenis_pegawai");
        $query->leftJoin("m_pegawai_agama AS pa", "p.id_agama", "pa.id_agama");
        $query->leftJoin("m_pegawai_pendidikan AS pd", "p.id_pendidikan", "pd.id_pendidikan");
        $query->leftJoin("m_pegawai_jurusan AS pjs", "p.id_jurusan", "pjs.id_jurusan");
        $query->leftJoin("m_pegawai_jabatan AS pjb", "p.id_jabatan", "pjb.id_jabatan");
        $query->leftJoin("m_pegawai_pangkat AS ppg", "p.id_pangkat", "ppg.id_pangkat");
        $query->leftJoin("m_pegawai_penugasan AS pp", "p.id_penugasan", "pp.id_penugasan");
        $query->leftJoin("m_pegawai_penempatan AS ppt", "p.id_penempatan", "ppt.id_penempatan");
        $query->leftJoin("m_pegawai_lokasi AS pl", "ppt.id_lokasi", "pl.id_lokasi");
        $query->leftJoin("m_pegawai_unit_kerja_sub AS psu", "p.id_sub_unit_kerja", "psu.id_sub_unit_kerja");
        $query->leftJoin("m_pegawai_unit_kerja AS pu", "psu.id_unit_kerja", "pu.id_unit_kerja");
        $query->leftJoin("m_pegawai_group AS pg", "p.id_group", "pg.id_group");
        $query->leftJoin("m_pegawai_eselon AS pe", "p.id_eselon", "pe.id_eselon");
        $query->leftJoin("pegawai_info AS pi", "p.nip_nik", "pi.nip_nik");
        $query->selectRaw("p.nip_nik,p.nrk_id_pjlp,p.photo,p.nama_pegawai,p.gelar_depan,p.gelar_belakang,p.jenis_kelamin,p.tempat_lahir,DATE_FORMAT(p.tanggal_lahir, '%d %M %Y') AS tanggal_lahir,p.no_telepon,p.email");
        $query->selectRaw("pkkp.nama_provinsi AS provinsi_ktp,pkkt.nama_kota AS kota_ktp,pkkc.nama_kecamatan AS kecamatan_ktp,pkkl.nama_kelurahan AS kelurahan_ktp,p.alamat_ktp");
        $query->selectRaw("pdkp.nama_provinsi AS provinsi_domisili,pdkt.nama_kota AS kota_domisili,pdkc.nama_kecamatan AS kecamatan_domisili,pdkl.nama_kelurahan AS kelurahan_domisili,p.alamat_domisili");
        $query->selectRaw("pj.nama_jenis_pegawai AS jenis_pegawai");
        $query->selectRaw("pa.nama_agama AS agama");
        $query->selectRaw("pd.nama_pendidikan AS pendidikan");
        $query->selectRaw("pjs.nama_jurusan AS jurusan");
        $query->selectRaw("pjb.nama_jabatan AS jabatan,pjb.kelas_jabatan,pjb.kategori_jabatan");
        $query->selectRaw("ppg.nama_pangkat AS pangkat,ppg.nama_golongan AS golongan");
        $query->selectRaw("pp.nama_penugasan AS penugasan");
        $query->selectRaw("ppt.nama_penempatan AS penempatan");
        $query->selectRaw("pl.nama_lokasi AS lokasi");
        $query->selectRaw("pu.nama_unit_kerja AS unit_kerja");
        $query->selectRaw("psu.nama_sub_unit_kerja AS sub_unit_kerja");
        $query->selectRaw("pg.nama_group AS `group`");
        $query->selectRaw("pe.nama_eselon AS eselon");
        $query->selectRaw("pi.photo_kasual,pi.no_karpeg,pi.no_npwp,pi.akun_jaki");
        $query->selectRaw("pi.no_sk_cpns,pi.no_sk_pns,pi.no_sk_terakhir");
        $query->selectRaw("DATE_FORMAT(pi.tmt_pangkat, '%d %M %Y') AS tmt_pangkat,DATE_FORMAT(pi.tmt_jabatan, '%d %M %Y') AS tmt_jabatan,DATE_FORMAT(pi.tmt_eselon, '%d %M %Y') AS tmt_eselon,DATE_FORMAT(pi.tmt_cpns, '%d %M %Y') AS tmt_cpns,DATE_FORMAT(pi.tmt_pns, '%d %M %Y') AS tmt_pns");
        $query->selectRaw("pi.tinggi,pi.berat,pi.golongan_darah,pi.ukuran_baju,pi.ukuran_celana,pi.ukuran_sepatu");
        $query->selectRaw("DATEDIFF(CURDATE(),pi.tmt_cpns) AS masa_kerja");
        $query->whereRaw("p.nip_nik = '" . (int)$user->nip . "'");
        $row = $query->first();
        if ($row) {
            $photo = _diskPathUrl('pegawai', $row->photo, config('app.placeholder.nophoto'));
            $photo_casual = _diskPathUrl('pegawai', $row->photo_kasual, config('app.placeholder.nophoto'));
            $gender = "";
            if ($row->jenis_kelamin == "L") {
                $gender = "Laki-laki";
            } else if ($row->jenis_kelamin == "P") {
                $gender = "Perempuan";
            }
            $address_ktp = $row->alamat_ktp;
            $address_ktp .= "\n" . $row->kelurahan_ktp . ", " . $row->kecamatan_ktp;
            $address_ktp .= "\n" . $row->kota_ktp . " - " . $row->provinsi_ktp;
            $address_domisili = $row->alamat_domisili;
            $address_domisili .= "\n" . $row->kelurahan_domisili . ", " . $row->kecamatan_domisili;
            $address_domisili .= "\n" . $row->kota_domisili . " - " . $row->provinsi_domisili;
            $data =
                [
                    "nip" => (int)$row->nip_nik,
                    "nrk" => (int)$row->nrk_id_pjlp,
                    "photo" => (string)$photo,
                    "photo_casual" => (string)$photo_casual,
                    "nama" => (string)($row->gelar_depan ? $row->gelar_depan . " " : "") . $row->nama_pegawai . ($row->gelar_belakang ? " " . $row->gelar_belakang : ""),
                    "jenis_kelamin" => (string)$gender,
                    "tempat_lahir" => (string)$row->tempat_lahir,
                    "tanggal_lahir" => (string)$row->tanggal_lahir,
                    "no_telepon" => (string)$row->no_telepon,
                    "email" => (string)$row->email,
                    "alamat_ktp" => (string)$address_ktp,
                    "alamat_domisili" => (string)$address_domisili,
                    "jenis_pegawai" => (string)$row->jenis_pegawai,
                    "agama" => (string)$row->agama,
                    "pendidikan" => (string)$row->pendidikan,
                    "jurusan" => (string)$row->jurusan,
                    "jabatan" => (string)$row->jabatan,
                    "kelas_jabatan" => (string)$row->kelas_jabatan,
                    "kategori_jabatan" => (string)$row->kategori_jabatan,
                    "pangkat" => (string)$row->pangkat,
                    "golongan" => (string)$row->golongan,
                    "penugasan" => (string)$row->penugasan,
                    "penempatan" => (string)$row->penempatan,
                    "lokasi" => (string)$row->lokasi,
                    "unit_kerja" => (string)$row->unit_kerja,
                    "sub_unit_kerja" => (string)$row->sub_unit_kerja,
                    "group" => (string)$row->group,
                    "eselon" => (string)$row->eselon,
                    "no_karpeg" => (string)$row->no_karpeg,
                    "no_npwp" => (string)$row->no_npwp,
                    "akun_jaki" => (string)$row->akun_jaki,
                    "no_sk_cpns" => (string)$row->no_sk_cpns,
                    "no_sk_pns" => (string)$row->no_sk_pns,
                    "no_sk_terakhir" => (string)$row->no_sk_terakhir,
                    "tmt_pangkat" => (string)$row->tmt_pangkat,
                    "tmt_jabatan" => (string)$row->tmt_jabatan,
                    "tmt_eselon" => (string)$row->tmt_eselon,
                    "tmt_cpns" => (string)$row->tmt_cpns,
                    "tmt_pns" => (string)$row->tmt_pns,
                    "masa_kerja" => (string)_convertDay($row->masa_kerja),
                    "tinggi" => (string)$row->tinggi . " cm",
                    "berat" => (string)$row->berat . " kg",
                    "golongan_darah" => (string)$row->golongan_darah,
                    "ukuran_baju" => (string)$row->ukuran_baju,
                    "ukuran_celana" => (string)$row->ukuran_celana,
                    "ukuran_sepatu" => (string)$row->ukuran_sepatu,
                ];
            return view('account.view', ['row' => json_decode(json_encode($data))]);
        }
        abort(403);
    }

    public function password_form()
    {
        $data["title"] = "Ubah Password";
        return view('account.password', $data);
    }

    public function password_save(Request $request)
    {
        try {
            $request->validate([
                'password_current' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $user = $request->user();
            $created_from = "SSO";
            $created_by = -1;
            $ip_address = $request->ip();
            $user_agent = $request->userAgent();
            $user->update([
                'password' => Hash::make($request->string('password')),
                'updated_at' => now(),
                'updated_from' => 'SSO',
                'updated_by' => $created_by,
            ]);
            $history['nip_nik'] = $user->nip;
            $history['description'] = "Pegawai melakukan perubahan password";
            $history['ip_address'] = $ip_address;
            $history['user_agent'] = $user_agent;
            $history['created_from'] = $created_from;
            $history['created_by'] = $created_by;
            _insertData("central", "pegawai_history", $history);

            event(new PasswordReset($user));

            if ($user->email) {
                $_email = [
                    'subject' => 'Informasi Perubahan Password',
                    'title' => 'Informasi Perubahan Password',
                    'content' => 'email.auth.change_password',
                ];
                app(\App\Classes\EmailController::class)->queue($user->email, $_email);
            }

            return response()->json([
                'status' => TRUE,
                'message' => __('response.data_updated'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => FALSE,
                'message' => $e->getMessage()
            ]);
        }
    }

}
