<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichDangKy extends Model
{
    protected $table = 'lich_dang_kys';

    protected $fillable = [
        'ngay_gio',
        'ghi_chu',
        'nhan_vien_id',
        'khach_hang_id',
    ];

    protected $casts = [
        'ngay_gio' => 'datetime',
    ];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhan_vien_id');
    }
}
