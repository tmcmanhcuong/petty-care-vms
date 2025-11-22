<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class KhachHang extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'khach_hangs';

    protected $fillable = [
        'ho_lot',
        'ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'dia_chi',
        'anh_dai_dien',
        'trang_thai',
    ];

    // hide password when serializing
    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];
}
