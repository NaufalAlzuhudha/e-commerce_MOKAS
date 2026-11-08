<?php

namespace App\Services;

use App\Models\Motorcycle;
use App\Models\MotorcycleImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    protected string $disk = 'public';
    protected string $directory = 'motorcycles';

    /**
     * Store multiple uploaded images for a motorcycle.
     *
     * @param Motorcycle $motorcycle
     * @param array<UploadedFile> $images
     * @param int|null $primaryIndex
     * @return array<MotorcycleImage>
     */
    public function uploadImages(Motorcycle $motorcycle, array $images, ?int $primaryIndex = 0): array
    {
        $createdImages = [];
        $existingCount = $motorcycle->images()->count();
        $hasExistingPrimary = $motorcycle->images()->where('is_primary', true)->exists();

        foreach ($images as $index => $imageFile) {
            if (!$imageFile instanceof UploadedFile) {
                continue;
            }

            // Generate clean random filename
            $extension = $imageFile->getClientOriginalExtension();
            $filename = 'unit_' . $motorcycle->id . '_' . Str::random(10) . '_' . time() . '.' . $extension;
            $path = $imageFile->storeAs($this->directory, $filename, $this->disk);

            $isPrimary = false;
            if (!$hasExistingPrimary && $existingCount === 0 && ($primaryIndex === null || $index === (int) $primaryIndex)) {
                $isPrimary = true;
                $hasExistingPrimary = true;
            }

            $createdImages[] = MotorcycleImage::create([
                'motorcycle_id' => $motorcycle->id,
                'image_path' => $path,
                'is_primary' => $isPrimary,
                'sort_order' => $existingCount + $index,
            ]);
        }

        // If no primary image exists at all, make the first image primary
        if (!$motorcycle->images()->where('is_primary', true)->exists()) {
            $first = $motorcycle->images()->first();
            if ($first) {
                $first->update(['is_primary' => true]);
            }
        }

        return $createdImages;
    }

    /**
     * Delete an image from storage and database.
     */
    public function deleteImage(MotorcycleImage $image): bool
    {
        $motorcycle = $image->motorcycle;
        $wasPrimary = $image->is_primary;

        // Delete from physical storage
        if ($image->image_path && Storage::disk($this->disk)->exists($image->image_path)) {
            Storage::disk($this->disk)->delete($image->image_path);
        }

        $deleted = $image->delete();

        // If we deleted the primary image, promote the next image to primary
        if ($wasPrimary && $motorcycle) {
            $nextImage = $motorcycle->images()->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        return (bool) $deleted;
    }

    /**
     * Set a specific image as primary for its motorcycle.
     */
    public function setPrimaryImage(MotorcycleImage $image): void
    {
        MotorcycleImage::where('motorcycle_id', $image->motorcycle_id)
            ->update(['is_primary' => false]);

        $image->update(['is_primary' => true]);
    }

    /**
     * Delete all physical images of a motorcycle.
     */
    public function deleteAllImages(Motorcycle $motorcycle): void
    {
        foreach ($motorcycle->images as $image) {
            if ($image->image_path && Storage::disk($this->disk)->exists($image->image_path)) {
                Storage::disk($this->disk)->delete($image->image_path);
            }
            $image->delete();
        }
    }
}
