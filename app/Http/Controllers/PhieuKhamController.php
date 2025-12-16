<?php

namespace App\Http\Controllers;

use App\Models\PhieuKham;
use Illuminate\Http\Request;

class PhieuKhamController extends Controller
{
    /**
     * Thêm mới phiếu khám
     */
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'lich_hen_id' => 'required|exists:lich_hens,id',
                'nhiet_do' => 'nullable|numeric|between:30,45',
                'can_nang' => 'nullable|numeric|min:0',
                'nhip_tim' => 'nullable|integer|between:30,200',
                'nhip_tho' => 'nullable|integer|between:5,50',
                'ly_do_den_kham' => 'nullable|string|max:255',
                'trieu_chung' => 'nullable|string',
                'chan_doan' => 'nullable|string',
                'ghi_chu' => 'nullable|string',
                'loai_chi_dinh' => 'required|in:chi_dinh_can_lam_sang,don_thuoc,hen_tai_kham',
            ]);

            // Lấy user đang đăng nhập
            $user = auth('sanctum')->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Vui lòng đăng nhập',
                    'errors' => ['auth' => 'Chưa xác thực']
                ], 401);
            }

            // Kiểm tra xem user có phải NhanVien không
            $nhanVienId = null;

            if ($user instanceof \App\Models\NhanVien) {
                $nhanVienId = $user->id;
            } elseif ($user instanceof \App\Models\Admin) {
                // Admin phải cung cấp nhan_vien_id trong request
                if (!$request->has('nhan_vien_id')) {
                    return response()->json([
                        'message' => 'Admin phải cung cấp nhan_vien_id',
                        'errors' => ['nhan_vien_id' => 'Bắt buộc']
                    ], 422);
                }
                $nhanVienId = $request->input('nhan_vien_id');
            } else {
                    return response()->json([
                    'message' => 'Chỉ nhân viên hoặc admin có thể tạo phiếu khám',
                    'errors' => ['auth' => 'Quyền hạn không đủ']
                ], 403);
            }

            // Thêm nhan_vien_id vào validated data
            $validated['nhan_vien_id'] = $nhanVienId;

            // Tạo phiếu khám
            $phieuKham = PhieuKham::create($validated);

            return response()->json([
                'message' => 'Thêm phiếu khám thành công',
                'data' => $phieuKham,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi thêm phiếu khám',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lấy danh sách tất cả phiếu khám
     */
    public function index()
    {
        try {
            $phieuKhams = PhieuKham::with(['lichHen', 'nhanVien'])
                ->paginate(15);

            return response()->json([
                'message' => 'Lấy danh sách phiếu khám thành công',
                'data' => $phieuKhams->items(),
                'pagination' => [
                    'total' => $phieuKhams->total(),
                    'per_page' => $phieuKhams->perPage(),
                    'current_page' => $phieuKhams->currentPage(),
                    'last_page' => $phieuKhams->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi lấy danh sách phiếu khám',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PhieuKham $phieuKham)
    {
        //
    }

    /**
     * Show the form for editing the existing resource.
     */
    public function edit(PhieuKham $phieuKham)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhieuKham $phieuKham)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhieuKham $phieuKham)
    {
        //
    }
}
