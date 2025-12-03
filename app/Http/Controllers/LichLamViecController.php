<?php

namespace App\Http\Controllers;

use App\Http\Requests\LichLamViecRequest;
use App\Models\LichLamViec;
use App\Models\Admin;
use App\Notifications\LichLamViecCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LichLamViecController extends Controller
{
    /**
     * Store a newly created schedule in storage.
     */
    public function store(LichLamViecRequest $request): JsonResponse
    {
        $data = $request->validated();

        $lich = LichLamViec::create($data);

        // Notify the assigned employee
        try {
            if ($lich->nhanVien) {
                $lich->nhanVien->notify(new LichLamViecCreatedNotification($lich));
            }
        } catch (\Throwable $e) {
            // ignore notification errors
        }

        // Notify admins (if any)
        try {
            if (class_exists(Admin::class)) {
                $admins = Admin::all();
                foreach ($admins as $admin) {
                    $admin->notify(new LichLamViecCreatedNotification($lich));
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return response()->json([
            'status' => true,
            'message' => 'Lịch làm việc đã được tạo.',
            'data' => $lich,
        ], 201);
    }

    /**
     * Display a listing of schedules. Supports optional filters:
     * - ngay_lam (YYYY-MM-DD)
     * - nhan_vien_id
     * - thoi_gian_truc (ca_sang|ca_chieu|ca_toi)
     * Returns paginated results with the assigned employee loaded.
     */
    public function index(Request $request): JsonResponse
    {
        $query = LichLamViec::with('nhanVien');

        if ($request->filled('ngay_lam')) {
            $query->whereDate('ngay_lam', $request->get('ngay_lam'));
        }

        if ($request->filled('nhan_vien_id')) {
            $query->where('nhan_vien_id', $request->get('nhan_vien_id'));
        }

        if ($request->filled('thoi_gian_truc')) {
            $query->where('thoi_gian_truc', $request->get('thoi_gian_truc'));
        }

        $perPage = (int) $request->get('per_page', 20);
        $lichs = $query->orderBy('ngay_lam', 'asc')->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $lichs,
        ]);
    }

    /**
     * Display a single schedule.
     */
    public function show(LichLamViec $lichLamViec): JsonResponse
    {
        $lich = $lichLamViec->load('nhanVien');
        return response()->json([
            'status' => true,
            'data' => $lich,
        ]);
    }
}
