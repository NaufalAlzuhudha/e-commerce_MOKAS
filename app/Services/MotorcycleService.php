<?php

namespace App\Services;

use App\Models\Motorcycle;
use App\Models\MotorcycleImage;
use Illuminate\Support\Facades\DB;

class MotorcycleService
{
    public function __construct(
        protected ImageUploadService $imageUploadService
    ) {}

    /**
     * Create a new motorcycle product with images.
     */
    public function createMotorcycle(array $data, ?array $images = null, ?int $primaryImageIndex = 0, int $userId = 1): Motorcycle
    {
        return DB::transaction(function () use ($data, $images, $primaryImageIndex, $userId) {
            $data['created_by'] = $userId;

            if ($data['status'] === Motorcycle::STATUS_PUBLISHED && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            $motorcycle = Motorcycle::create($data);

            if (!empty($images)) {
                $this->imageUploadService->uploadImages($motorcycle, $images, $primaryImageIndex);
            }

            return $motorcycle;
        });
    }

    /**
     * Update an existing motorcycle product.
     */
    public function updateMotorcycle(Motorcycle $motorcycle, array $data, ?array $newImages = null, ?int $primaryImageId = null): Motorcycle
    {
        return DB::transaction(function () use ($motorcycle, $data, $newImages, $primaryImageId) {
            // Set published_at timestamp when transitioning to published
            if ($data['status'] === Motorcycle::STATUS_PUBLISHED && !$motorcycle->published_at) {
                $data['published_at'] = now();
            }

            $motorcycle->update($data);

            if (!empty($newImages)) {
                $this->imageUploadService->uploadImages($motorcycle, $newImages);
            }

            if ($primaryImageId) {
                $targetImage = MotorcycleImage::where('motorcycle_id', $motorcycle->id)
                    ->where('id', $primaryImageId)
                    ->first();

                if ($targetImage) {
                    $this->imageUploadService->setPrimaryImage($targetImage);
                }
            }

            return $motorcycle->fresh(['brand', 'images']);
        });
    }

    /**
     * Delete a motorcycle and all its physical images.
     */
    public function deleteMotorcycle(Motorcycle $motorcycle): bool
    {
        return DB::transaction(function () use ($motorcycle) {
            $this->imageUploadService->deleteAllImages($motorcycle);
            return (bool) $motorcycle->delete();
        });
    }

    /**
     * Get summary metrics for the dashboard.
     */
    public function getDashboardStats(): array
    {
        return [
            'total' => Motorcycle::count(),
            'published' => Motorcycle::where('status', Motorcycle::STATUS_PUBLISHED)->count(),
            'sold' => Motorcycle::where('status', Motorcycle::STATUS_SOLD)->count(),
            'draft' => Motorcycle::where('status', Motorcycle::STATUS_DRAFT)->count(),
            'inactive' => Motorcycle::where('status', Motorcycle::STATUS_INACTIVE)->count(),
        ];
    }
}
