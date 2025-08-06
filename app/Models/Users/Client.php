<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $connection = 'central';
    protected $table = 'sso_client';

    protected $fillable = [
        'image',
        'name',
        'client_id',
        'client_secret',
        'url_web',
        'url_auth',
        'api',
        'web',
        'status',
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

    protected $hidden = [
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
        'created_user',
        'updated_user',
    ];

    protected $appends = ['image', 'api', 'web', 'status', 'is_valid', 'created_user', 'updated_user'];

    public function scopeActive(Builder $query)
    {
        $query->where('status_id', 1);
    }

    public function getImageAttribute()
    {
        $image = $this->attributes['image'] ?? "";
        return _diskPathUrl('central', $image, config('app.placeholder.default'));
    }

    public function getApiAttribute()
    {
        $status = $this->attributes['api'] ?? 0;
        return '<span class="badge badge-light-' . ($status == 1 ? "primary" : "default") . ' fw-bolder">' . ($status == 1 ? "YES" : "NO") . '</span>';
    }

    public function getWebAttribute()
    {
        $status = $this->attributes['web'] ?? 0;
        return '<span class="badge badge-light-' . ($status == 1 ? "primary" : "default") . ' fw-bolder">' . ($status == 1 ? "YES" : "NO") . '</span>';
    }

    public function getStatusAttribute()
    {
        $status = $this->attributes['status'] ?? 0;
        return '<span class="badge badge-light-' . ($status == 1 ? "primary" : "default") . ' fw-bolder">' . ($status == 1 ? "ACTIVE" : "NON-ACTIVE") . '</span>';
    }

    public function getIsValidAttribute()
    {
        return (bool)(($this->attributes['status'] ?? 0) == 1);
    }

    public function getCreatedUserAttribute()
    {
        $createdfrom = $this->created_from ?? 'Back Office';
        $createdby = $this->created_by ?? -1;
        return _createdBy($createdfrom, $createdby);
    }

    public function getUpdatedUserAttribute()
    {
        $createdfrom = $this->updated_from ?? 'Back Office';
        $createdby = $this->updated_by ?? -1;
        return _createdBy($createdfrom, $createdby);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d F Y H:i:s',
            'updated_at' => 'datetime:d F Y H:i:s',
        ];
    }
}
