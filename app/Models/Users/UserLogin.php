<?php

namespace App\Models\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Users\Pegawai;

class UserLogin extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'user_login';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'client_id',
        'token',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'client_id',
        'token',
    ];

    protected $appends = ['data'];

    public function getDataAttribute()
    {
        $pegawai = Pegawai::firstWhere('nrk_id_pjlp', $this->user_id);
        if ($pegawai) {
            return $pegawai->makeVisible('roles');
        }
        return NULL;
    }

    public function getIsValidAttribute()
    {
        $pegawai = $this->getDataAttribute();
        return (bool)($pegawai);
    }
}
