<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KhoaController;
use App\Http\Controllers\LichLamViecController;
use App\Http\Controllers\NhanVienController;
use App\Models\KhachHang;
use App\Http\Controllers\ThuCungController;
use App\Http\Controllers\LichHenController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\DanhMucDichVuController;
use App\Http\Controllers\DanhMucHangHoaController;


Route::post('/khach-hang/dang-ki', [KhachHangController::class, 'dangKi']);
Route::post('/khach-hang/dang-nhap', [KhachHangController::class, 'dangNhap']);


// Routes đăng nhập mạng xã hội
Route::get('/auth/google', [KhachHangController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [KhachHangController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [KhachHangController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [KhachHangController::class, 'handleFacebookCallback']);

// Route xác thực Email
Route::get('/email/verify/{id}/{hash}', [KhachHangController::class, 'verifyEmail'])->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => true,
            'data' => $request->user()
        ]);
    });

    Route::post('/khach-hang/cap-nhat', [KhachHangController::class, 'capNhat']);
    Route::put('/khach-hang/{id}', [KhachHangController::class, 'update']);

    // Thu cưng routes (require authentication)
    Route::get('/thu-cung', [ThuCungController::class, 'index']);
    Route::get('/thu-cung/{thuCung}', [ThuCungController::class, 'show']);
    Route::post('/thu-cung', [ThuCungController::class, 'store']);
    Route::put('/thu-cung/{thuCung}', [ThuCungController::class, 'update']);
    Route::patch('/thu-cung/{thuCung}', [ThuCungController::class, 'update']);
    Route::delete('/thu-cung/{thuCung}', [ThuCungController::class, 'destroy']);

    // Appointments (lich_hen)
    Route::post('/lich-hen', [LichHenController::class, 'store']);
    Route::get('/lich-hen', [LichHenController::class, 'index']);
    Route::get('/lich-hen/{lichHen}', [LichHenController::class, 'show']);
    Route::patch('/lich-hen/{lichHen}/ngay-gio', [LichHenController::class, 'updateNgayGio']);
    Route::delete('/lich-hen/{lichHen}', [LichHenController::class, 'destroy']);
    // Lịch làm việc: tạo mới
    Route::post('/lich-lam-viec', [LichLamViecController::class, 'store']);
    // Lịch làm việc: list & view
    Route::get('/lich-lam-viec', [LichLamViecController::class, 'index']);
    Route::get('/lich-lam-viec/{lichLamViec}', [LichLamViecController::class, 'show']);
});

// Public: list services
Route::get('/dich-vu', [DichVuController::class, 'index']);
// Public: view single service
Route::get('/dich-vu/{dichVu}', [DichVuController::class, 'show']);

// Public: list and view service categories
Route::get('/danh-muc-dich-vu', [DanhMucDichVuController::class, 'index']);
Route::get('/danh-muc-dich-vu/{danhMucDichVu}', [DanhMucDichVuController::class, 'show']);

// Public: list and view product categories
Route::get('/danh-muc-hang-hoa', [DanhMucHangHoaController::class, 'index']);
Route::get('/danh-muc-hang-hoa/{danhMucHangHoa}', [DanhMucHangHoaController::class, 'show']);

// Admin login route
Route::post('/admin/dang-nhap', [AdminController::class, 'dangNhap']);

// Admin authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/dang-xuat', [AdminController::class, 'dangXuat']);

    // Khoa: tạo mới (chỉ admin)
    Route::post('/khoa', [KhoaController::class, 'store'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Nhân viên: tạo mới (chỉ admin)
    Route::post('/nhan-vien', [NhanVienController::class, 'store'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Nhân viên: đổi mật khẩu (chỉ admin)
    Route::patch('/nhan-vien/{nhanVien}/mat-khau', [NhanVienController::class, 'changePassword'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Nhân viên: khóa tài khoản (chỉ admin)
    Route::patch('/nhan-vien/{nhanVien}/khoa', [NhanVienController::class, 'lockAccount'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Nhân viên: mở khóa tài khoản (chỉ admin)
    Route::patch('/nhan-vien/{nhanVien}/mo-khoa', [NhanVienController::class, 'unlockAccount'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Nhân viên: danh sách (chỉ admin)
    Route::get('/nhan-vien', [NhanVienController::class, 'index'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Danh mục dịch vụ: tạo mới (chỉ admin)
    Route::post('/danh-muc-dich-vu', [\App\Http\Controllers\DanhMucDichVuController::class, 'store'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Danh mục hàng hóa: tạo mới (chỉ admin)
    Route::post('/danh-muc-hang-hoa', [\App\Http\Controllers\DanhMucHangHoaController::class, 'store'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Dich vu: tạo mới (chỉ admin)
    Route::post('/dich-vu', [\App\Http\Controllers\DichVuController::class, 'store'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Dich vu: update & delete (admin)
    Route::match(['put', 'patch'], '/dich-vu/{dichVu}', [\App\Http\Controllers\DichVuController::class, 'update'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    Route::delete('/dich-vu/{dichVu}', [\App\Http\Controllers\DichVuController::class, 'destroy'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // File upload for admin (images etc.)
    Route::post('/upload', [\App\Http\Controllers\UploadController::class, 'store'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Danh mục dịch vụ: xóa (chỉ admin)
    Route::delete('/danh-muc-dich-vu/{danhMucDichVu}', [\App\Http\Controllers\DanhMucDichVuController::class, 'destroy'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    // Danh mục hàng hoa: update & delete (admin)
    Route::match(['put', 'patch'], '/danh-muc-hang-hoa/{danhMucHangHoa}', [\App\Http\Controllers\DanhMucHangHoaController::class, 'update'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
    Route::delete('/danh-muc-hang-hoa/{danhMucHangHoa}', [\App\Http\Controllers\DanhMucHangHoaController::class, 'destroy'])->middleware(\App\Http\Middleware\EnsureAdmin::class);
});
