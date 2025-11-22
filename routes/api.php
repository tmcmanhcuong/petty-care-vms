<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KhachHangController;
use App\Models\KhachHang;


Route::post('/khach-hang/dang-ki', [KhachHangController::class, 'dangKi']);
Route::post('/khach-hang/dang-nhap', [KhachHangController::class, 'dangNhap']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/khach-hang/cap-nhat', [KhachHangController::class, 'capNhat']);
    Route::put('/khach-hang/{id}', [KhachHangController::class, 'update']);
});
