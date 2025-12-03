<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HangHoa extends Model
{
    use HasFactory;

    protected $table = 'hang_hoas';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'danh_muc_hang_hoa_id',
        // add other fillable attributes of HangHoa here (ten, gia, etc.)
    ];

    /**
     * The category this product belongs to.
     */
    public function danhMuc()
    {
        return $this->belongsTo(\App\Models\DanhMucHangHoa::class, 'danh_muc_hang_hoa_id');
    }
}
