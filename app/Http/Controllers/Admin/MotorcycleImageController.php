<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MotorcycleImage;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MotorcycleImageController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageUploadService
    ) {}

    /**
     * Delete a single image from a motorcycle.
     */
    public function destroy(Request $request, MotorcycleImage $image): JsonResponse|RedirectResponse
    {
        $this->imageUploadService->deleteImage($image);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus.',
            ]);
        }

        return back()->with('success', 'Foto unit berhasil dihapus.');
    }

    /**
     * Set a single image as primary for its motorcycle.
     */
    public function setPrimary(Request $request, MotorcycleImage $image): JsonResponse|RedirectResponse
    {
        $this->imageUploadService->setPrimaryImage($image);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto utama berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Foto utama unit berhasil diperbarui.');
    }
}

