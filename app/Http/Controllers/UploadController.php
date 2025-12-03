<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    /**
     * Handle a generic file upload (images) and return a public URL.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $file = $request->file('file');
            $path = $file->store('dichvu/images', 'public');

            // Storage::url returns path for the disk; url() will convert to full URL
            $publicUrl = url(Storage::url($path));

            return response()->json([
                'status' => true,
                'message' => 'File uploaded',
                'data' => [
                    'path' => $publicUrl,
                    'url' => $publicUrl,
                    'file' => basename($path),
                ],
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Upload failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => false,
                'message' => 'Could not store file. Please try again later.'
            ], 500);
        }
    }
}
