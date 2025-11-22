<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class KhachHangController extends Controller
{
    public function dangKi(Request $request): JsonResponse
    {
        $input = $request->all();
        if (isset($input['so_dien_thoai'])) {
            $input['so_dien_thoai'] = preg_replace('/\D+/', '', (string) $input['so_dien_thoai']);
        }

        $rules = [
            'ho_ten' => 'required|string|max:191',
            'email' => 'required|email|unique:khach_hangs,email',
            'mat_khau' => 'required|string|min:8',
            'so_dien_thoai' => ['required', 'regex:/^[0-9]{10}$/'],
            'dia_chi' => 'nullable|string|max:255',
            'anh_dai_dien' => 'nullable|string|max:255',
            'trang_thai' => 'nullable|integer|in:0,1',
        ];

        $messages = [
            'so_dien_thoai.required' => Lang::get('messages.phone_required'),
            'so_dien_thoai.regex' => Lang::get('messages.phone_invalid'),
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => Lang::get('messages.validation_failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        [$ho_lot, $ten] = $this->splitFullName($data['ho_ten']);

        $payload = [
            'ho_lot' => $ho_lot,
            'ten' => $ten,
            'email' => $data['email'],
            'mat_khau' => Hash::make($data['mat_khau']),
            'so_dien_thoai' => $data['so_dien_thoai'],
            'dia_chi' => $data['dia_chi'] ?? null,
            'anh_dai_dien' => $data['anh_dai_dien'] ?? null,
            'trang_thai' => $data['trang_thai'] ?? 1,
        ];

        try {
            $customer = KhachHang::create($payload);
        } catch (\Exception $e) {
            $safePayload = $payload;
            if (isset($safePayload['mat_khau'])) {
                unset($safePayload['mat_khau']);
            }
            Log::error('KhachHang::create failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $safePayload,
            ]);

            return response()->json([
                'status' => false,
                'message' => Lang::get('messages.server_error'),
            ], 500);
        }

        if (method_exists($customer, 'makeHidden')) {
            $customer->makeHidden(['mat_khau']);
        } else {
            unset($customer->mat_khau);
        }

        return response()->json([
            'status' => true,
            'message' => Lang::get('messages.registration_success'),
            'data' => $customer,
        ], 201);
    }


    private function splitFullName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName));
        $ten = array_pop($parts);
        $ho_lot = implode(' ', $parts) ?: '';
        return [$ho_lot, $ten];
    }

    private function handleAvatarUpload(Request $request)
    {
        if (! $request->hasFile('anh_dai_dien')) {
            return null;
        }

        $file = $request->file('anh_dai_dien');
        if (! $file->isValid()) return null;

        try {
            $path = $file->store('khachhang/avatars', 'public');
            return url(Storage::url($path));
        } catch (\Exception $e) {
            Log::error('Avatar store failed (helper)', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    private function assignProfileFields(KhachHang $model, array $data, Request $request): void
    {
        [$ho_lot, $ten] = $this->splitFullName($data['ho_ten']);
        $model->ho_lot = $ho_lot;
        $model->ten = $ten;
        $model->email = $data['email'];
        $model->so_dien_thoai = $data['so_dien_thoai'];
        $model->dia_chi = $data['dia_chi'] ?? $model->dia_chi;

        if ($request->hasFile('anh_dai_dien')) {
            $url = $this->handleAvatarUpload($request);
            if ($url) $model->anh_dai_dien = $url;
        } else {
            $model->anh_dai_dien = $data['anh_dai_dien'] ?? $model->anh_dai_dien;
        }

        if (isset($data['zalo']) && Schema::hasColumn('khach_hangs', 'zalo')) {
            $model->zalo = $data['zalo'];
        }
    }


    public function dangNhap(Request $request): JsonResponse
    {
        $rules = [
            'email' => 'required|email',
            'mat_khau' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => Lang::get('messages.validation_failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $validator->validated();

        $customer = KhachHang::where('email', $credentials['email'])->first();
        if (! $customer || ! \Illuminate\Support\Facades\Hash::check($credentials['mat_khau'], $customer->mat_khau)) {
            return response()->json([
                'status' => false,
                'message' => Lang::get('messages.login_failed'),
            ], 401);
        }

        try {
            $token = $customer->createToken('api-token')->plainTextToken;
        } catch (\Exception $e) {
            Log::error('Token creation failed: ' . $e->getMessage());
            $token = null;
        }

        if (method_exists($customer, 'makeHidden')) {
            $customer->makeHidden(['mat_khau']);
        }

        return response()->json([
            'status' => true,
            'message' => Lang::get('messages.login_success'),
            'data' => $customer,
            'token' => $token,
        ], 200);
    }

    public function capNhat(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user) {
            return response()->json(['status' => false, 'message' => Lang::get('messages.unauthorized')], 401);
        }

        $input = $request->all();
        if (isset($input['so_dien_thoai'])) {
            $input['so_dien_thoai'] = preg_replace('/\D+/', '', (string) $input['so_dien_thoai']);
        }

        $rules = [
            'ho_ten' => 'required|string|max:191',
            'email' => 'required|email|unique:khach_hangs,email,' . $user->id,
            'so_dien_thoai' => ['required', 'regex:/^[0-9]{10}$/'],
            'dia_chi' => 'nullable|string|max:255',
            'anh_dai_dien' => 'nullable',
        ];

        $messages = [
            'so_dien_thoai.required' => Lang::get('messages.phone_required'),
            'so_dien_thoai.regex' => Lang::get('messages.phone_invalid'),
        ];

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => Lang::get('messages.validation_failed'), 'errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('anh_dai_dien')) {
            $fileValidator = Validator::make($request->all(), [
                'anh_dai_dien' => 'file|image|mimes:jpg,jpeg,png,gif|max:5120',
            ]);
            if ($fileValidator->fails()) {
                return response()->json(['status' => false, 'message' => Lang::get('messages.validation_failed'), 'errors' => $fileValidator->errors()], 422);
            }
        }

        $data = $validator->validated();

        $this->assignProfileFields($user, $data, $request);

        try {
            $user->save();
        } catch (\Exception $e) {
            Log::error('Profile update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id ?? null,
            ]);
            return response()->json(['status' => false, 'message' => Lang::get('messages.server_error')], 500);
        }

        $user->refresh();

        return response()->json(['status' => true, 'message' => Lang::get('messages.update_success'), 'user' => $user], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $target = KhachHang::find($id);
        if (! $target) {
            return response()->json(['status' => false, 'message' => Lang::get('messages.not_found')], 404);
        }

        $input = $request->all();
        if (isset($input['so_dien_thoai'])) {
            $input['so_dien_thoai'] = preg_replace('/\D+/', '', (string) $input['so_dien_thoai']);
        }

        $rules = [
            'ho_ten' => 'required|string|max:191',
            'email' => 'required|email|unique:khach_hangs,email,' . $target->id,
            'so_dien_thoai' => ['required', 'regex:/^[0-9]{10}$/'],
            'dia_chi' => 'nullable|string|max:255',
            'anh_dai_dien' => 'nullable',
        ];

        $validator = Validator::make($input, $rules, [
            'so_dien_thoai.required' => Lang::get('messages.phone_required'),
            'so_dien_thoai.regex' => Lang::get('messages.phone_invalid'),
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => Lang::get('messages.validation_failed'), 'errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('anh_dai_dien')) {
            $fileValidator = Validator::make($request->all(), [
                'anh_dai_dien' => 'file|image|mimes:jpg,jpeg,png,gif|max:5120',
            ]);
            if ($fileValidator->fails()) {
                return response()->json(['status' => false, 'message' => Lang::get('messages.validation_failed'), 'errors' => $fileValidator->errors()], 422);
            }
        }

        $data = $validator->validated();

        $this->assignProfileFields($target, $data, $request);

        try {
            $target->save();
        } catch (\Exception $e) {
            Log::error('Profile update by id failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'target_id' => $target->id ?? null,
            ]);
            return response()->json(['status' => false, 'message' => Lang::get('messages.server_error')], 500);
        }

        return response()->json(['status' => true, 'message' => Lang::get('messages.update_success'), 'user' => $target], 200);
    }
}
