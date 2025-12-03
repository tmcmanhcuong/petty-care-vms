<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\Admin;
use App\Http\Requests\NhanVienRequest;
use App\Notifications\NhanVienCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all employees. Consider adding pagination if dataset grows.
        $nhanViens = NhanVien::all();

        return response()->json([
            'status' => true,
            'data' => $nhanViens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\NhanVienRequest $request)
    {
        $data = $request->validated();

        // If no password provided, generate a secure random password and include it
        $plainPassword = null;
        if (empty($data['password'])) {
            $plainPassword = Str::random(12);
            $data['password'] = $plainPassword;
        }

        // Create the employee
        $nhanVien = NhanVien::create($data);

        // Notify the created employee via email (and database if available)
        try {
            $nhanVien->notify(new NhanVienCreatedNotification($nhanVien, $plainPassword));
        } catch (\Throwable $e) {
            // swallow mail/notification exceptions to avoid breaking API
        }

        // Notify all admins (if any) about new employee via database (if supported)
        if (class_exists(Admin::class)) {
            try {
                $admins = Admin::all();
                foreach ($admins as $admin) {
                    $admin->notify(new NhanVienCreatedNotification($nhanVien));
                }
            } catch (\Throwable $e) {
                // ignore notification errors
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Tạo nhân viên thành công.',
            'data' => $nhanVien,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NhanVien $nhanVien)
    {
        //
    }

    /**
     * Change password for a given NhanVien.
     * Admins can call this endpoint to set a new password for an employee.
     */
    public function changePassword(Request $request, NhanVien $nhanVien)
    {
        $data = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu không hợp lệ.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $nhanVien->password = Hash::make($data['password']);
        $nhanVien->save();

        return response()->json([
            'status' => true,
            'message' => 'Đổi mật khẩu thành công.',
        ]);
    }

    /**
     * Lock the employee account so they cannot authenticate (revoke tokens).
     */
    public function lockAccount(NhanVien $nhanVien)
    {
        $nhanVien->trang_thai = 'da_khoa';
        $nhanVien->save();

        // Revoke all existing tokens so current sessions are invalidated
        try {
            $nhanVien->tokens()->delete();
        } catch (\Throwable $e) {
            // ignore token deletion errors
        }

        return response()->json([
            'status' => true,
            'message' => 'Tài khoản đã bị khóa.',
        ]);
    }

    /**
     * Unlock the employee account so they can authenticate again.
     */
    public function unlockAccount(NhanVien $nhanVien)
    {
        $nhanVien->trang_thai = 'hoat_dong';
        $nhanVien->save();

        return response()->json([
            'status' => true,
            'message' => 'Tài khoản đã được mở khóa.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhanVien $nhanVien)
    {
        //
    }
}
