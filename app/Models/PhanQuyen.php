<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PhanQuyen extends Model
{
    protected $table = 'phan_quyens';

    protected $fillable = [
        'name',
        'description',
    ];

    public function nhanViens(): BelongsToMany
    {
        return $this->belongsToMany(NhanVien::class, 'phan_quyen_nhan_vien', 'phan_quyen_id', 'nhan_vien_id');
    }
}
