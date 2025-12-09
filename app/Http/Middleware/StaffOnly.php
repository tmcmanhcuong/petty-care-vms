<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffOnly
{
    /**
     * Handle an incoming request.
     * Chỉ cho phép Admin và NhanVien truy cập
     * Chặn KhachHang/User
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Nếu chưa đăng nhập
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để tiếp tục'
            ], 401);
        }

        // Chỉ cho phép Admin và NhanVien
        if ($user instanceof \App\Models\Admin || $user instanceof \App\Models\NhanVien) {
            return $next($request);
        }

        // Chặn Khách hàng
        return response()->json([
            'success' => false,
            'message' => 'Chỉ quản trị viên và nhân viên mới có thể truy cập chức năng này.'
        ], 403);
    }
}
