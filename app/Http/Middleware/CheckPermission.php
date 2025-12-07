<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission  Tên quyền cần kiểm tra (vd: 'lich_hen_xem')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        // Nếu chưa đăng nhập
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để tiếp tục'
            ], 401);
        }

        // Kiểm tra xem user có phương thức hasPermission không
        if (!method_exists($user, 'hasPermission')) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xác định quyền của người dùng'
            ], 403);
        }

        // Kiểm tra quyền
        if (!$user->hasPermission($permission)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện chức năng này',
                'required_permission' => $permission
            ], 403);
        }

        return $next($request);
    }
}
