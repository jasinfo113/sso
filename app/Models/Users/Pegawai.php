<?php

namespace App\Models\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    public $timestamps = false;

    protected $connection = 'central';
    protected $table = 'pegawai';
    protected $primaryKey = 'nip_nik';
    protected $keyType = 'string';

    protected $fillable = [
        'photo',
        'nama_pegawai',
        'no_telepon',
        'email',
        'password',
        'alamat_ktp',
        'alamat_domisili',
        'id_kelurahan_ktp',
        'id_kelurahan_domisili',
    ];

    protected $hidden = [
        'nip_nik',
        'nrk_id_pjlp',
        'nama_pegawai',
        'gelar_depan',
        'gelar_belakang',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_ktp',
        'alamat_domisili',
        'keterangan',
        'password',
        'privileges',
        'id_kelurahan_ktp',
        'id_kelurahan_domisili',
        'id_jenis_pegawai',
        'id_agama',
        'id_pendidikan',
        'id_jurusan',
        'id_jabatan',
        'id_pangkat',
        'id_penugasan',
        'id_penempatan',
        'id_unit_kerja',
        'id_sub_unit_kerja',
        'id_group',
        'id_eselon',
        'id_status',
        'email_verified_at',
        'phone_verified_at',
        'created_at',
        'created_from',
        'created_by',
        'updated_at',
        'updated_from',
        'updated_by',
        'is_deleted',
        'deleted_at',
        'deleted_from',
        'deleted_by',
    ];

    protected $appends = [
        'nip',
        'nrk',
        'nama',
        'photo',
        'jenis_pegawai',
        'jabatan',
        'penugasan',
        'penempatan',
        'group',
    ];

    public function getNipAttribute()
    {
        return (int)$this->nip_nik;
    }

    public function getNrkAttribute()
    {
        return (int)$this->nrk_id_pjlp;
    }

    public function getNamaAttribute()
    {
        return ($this->gelar_depan ? $this->gelar_depan . " " : "") . $this->nama_pegawai . ($this->gelar_belakang ? " " . $this->gelar_belakang : "");
    }

    public function getPhotoAttribute()
    {
        $photo = $this->attributes['photo'] ?? "";
        $photo_casual = _singleData("central", "pegawai_info", "photo_kasual AS photo", "nip_nik = '" . $this->nip_nik . "'")->photo ?? "";
        if ($photo_casual) {
            return _diskPathUrl('pegawai', $photo_casual, config('app.placeholder.nophoto'));
        }
        return _diskPathUrl('pegawai', $photo, config('app.placeholder.nophoto'));
    }

    public function getJenisPegawaiAttribute()
    {
        return _singleData("central", "m_pegawai_jenis", "id_jenis_pegawai AS id, nama_jenis_pegawai AS `name`", "id_jenis_pegawai = '" . $this->id_jenis_pegawai . "'");
    }

    public function getJabatanAttribute()
    {
        return _singleData("central", "m_pegawai_jabatan", "id_jabatan AS id, nama_jabatan AS `name`", "id_jabatan = '" . $this->id_jabatan . "'");
    }

    public function getPenugasanAttribute()
    {
        return _singleData("central", "m_pegawai_penugasan", "id_penugasan AS id, nama_penugasan AS `name`", "id_penugasan = '" . $this->id_penugasan . "'");
    }

    public function getPenempatanAttribute()
    {
        $row = DB::connection("central")->table("m_pegawai_penempatan AS p")
            ->leftJoin("m_pegawai_unit_kerja_sub AS suk", "p.id_sub_unit_kerja", "suk.id_sub_unit_kerja")
            ->leftJoin("m_pegawai_unit_kerja AS uk", "suk.id_unit_kerja", "uk.id_unit_kerja")
            ->leftJoin("m_pegawai_lokasi AS l", "p.id_lokasi", "l.id_lokasi")
            ->leftJoin("m_area_wilayah AS w", "l.id_wilayah", "w.id_wilayah")
            ->leftJoin("m_area_sektor AS s", "l.id_sektor", "s.id_sektor")
            ->leftJoin("m_area_pos AS ap", "l.id_pos", "ap.id_pos")
            ->leftJoin("m_area_kelurahan AS akl", "l.id_kelurahan", "akl.id_kelurahan")
            ->leftJoin("m_area_kecamatan AS akc", "akl.id_kecamatan", "akc.id_kecamatan")
            ->leftJoin("m_area_kota AS ak", "akc.id_kota", "ak.id_kota")
            ->selectRaw("p.id_penempatan, p.nama_penempatan")
            ->selectRaw("suk.id_sub_unit_kerja, suk.nama_sub_unit_kerja")
            ->selectRaw("uk.id_unit_kerja, uk.nama_unit_kerja")
            ->selectRaw("l.id_lokasi, l.nama_lokasi")
            ->selectRaw("w.id_wilayah, w.nama_wilayah")
            ->selectRaw("s.id_sektor, s.nama_sektor")
            ->selectRaw("ap.id_pos, ap.nama_pos")
            ->selectRaw("ak.id_kota, ak.nama_kota")
            ->selectRaw("akc.id_kecamatan, akc.nama_kecamatan")
            ->selectRaw("akl.id_kelurahan, akl.nama_kelurahan")
            ->where("p.id_penempatan", $this->id_penempatan)
            ->first();
        if ($row) {
            $data =
                [
                    "id" => (int)$row->id_penempatan,
                    "name" => (string)$row->nama_penempatan,
                    "unit_kerja" =>
                    [
                        "id" => (int)$row->id_unit_kerja,
                        "name" => (string)$row->nama_unit_kerja,
                    ],
                    "sub_unit_kerja" =>
                    [
                        "id" => (int)$row->id_sub_unit_kerja,
                        "name" => (string)$row->nama_sub_unit_kerja,
                    ],
                    "wilayah" =>
                    [
                        "id" => (string)$row->id_wilayah,
                        "name" => (string)$row->nama_wilayah,
                    ],
                    "sektor" =>
                    [
                        "id" => (string)$row->id_sektor,
                        "name" => (string)$row->nama_sektor,
                    ],
                    "pos" =>
                    [
                        "id" => (string)$row->id_pos,
                        "name" => (string)$row->nama_pos,
                    ],
                    "kota" =>
                    [
                        "id" => (string)$row->id_kota,
                        "name" => (string)$row->nama_kota,
                    ],
                    "kecamatan" =>
                    [
                        "id" => (string)$row->id_kecamatan,
                        "name" => (string)$row->nama_kecamatan,
                    ],
                    "kelurahan" =>
                    [
                        "id" => (string)$row->id_kelurahan,
                        "name" => (string)$row->nama_kelurahan,
                    ],
                ];
            return json_decode(json_encode($data));
        }
        return NULL;
    }

    public function getGroupAttribute()
    {
        return _singleData("central", "m_pegawai_group", "id_group AS id, nama_group AS `name`", "id_group = '" . $this->id_group . "'");
    }

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date:d F Y',
            'tmt_pangkat' => 'date:d F Y',
            'tmt_eselon' => 'date:d F Y',
            'tmt_cpns' => 'date:d F Y',
        ];
    }
}
