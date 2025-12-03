<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoSoBenhAn extends Model
{
    protected $table = 'ho_so_benh_ans';

    protected $fillable = [
        'ma_benh_an',
        'noi_dung',
        'khach_hang_id',
        'nhan_vien_id',
    ];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhan_vien_id');
    }
}
