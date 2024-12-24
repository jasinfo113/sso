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
        'role',
        'roles',
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
        'jabatan',
        'penugasan',
        'penempatan',
        'group',
    ];

    public function getNipAttribute()
    {
        return $this->nip_nik;
    }

    public function getNrkAttribute()
    {
        return $this->nrk_id_pjlp;
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
            return _diskPathUrl('pegawai', $photo_casual, asset('assets/images/nophoto.png'));
        }
        return _diskPathUrl('pegawai', $photo, asset('assets/images/nophoto.png'));
    }

    public function getJabatanAttribute()
    {
        $data = DB::connection('central')->table('m_pegawai_jabatan')->select('nama_jabatan')->where('id_jabatan', $this->id_jabatan)->first();
        $value = $data->nama_jabatan ?? "";
        return $value;
    }

    public function getPenugasanAttribute()
    {
        $data = DB::connection('central')->table('m_pegawai_penugasan')->select('nama_penugasan')->where('id_penugasan', $this->id_penugasan)->first();
        $value = $data->nama_penugasan ?? "";
        return $value;
    }

    public function getPenempatanAttribute()
    {
        $data = DB::connection('central')->table('m_pegawai_penempatan')->select('nama_penempatan')->where('id_penempatan', $this->id_penempatan)->first();
        $value = $data->nama_penempatan ?? "";
        return $value;
    }

    public function getGroupAttribute()
    {
        $data = DB::connection('central')->table('m_pegawai_group')->select('nama_group')->where('id_group', $this->id_group)->first();
        $value = $data->nama_group ?? "";
        return $value;
    }

    protected function casts(): array
    {
        return [
            'nip_nik' => 'integer',
            'nrk_id_pjlp' => 'integer',
            'nip' => 'integer',
            'nrk' => 'integer',
            'tgl_lahir' => 'date:d F Y',
            'tmt_pangkat' => 'date:d F Y',
            'tmt_eselon' => 'date:d F Y',
            'tmt_cpns' => 'date:d F Y',
        ];
    }
}
