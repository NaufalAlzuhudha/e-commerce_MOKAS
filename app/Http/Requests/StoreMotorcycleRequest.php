<?php

namespace App\Http\Requests;

use App\Models\Motorcycle;
use Illuminate\Foundation\Http\FormRequest;

class StoreMotorcycleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $currentYear = (int) date('Y') + 1;

        return [
            'brand_id' => ['required', 'exists:brands,id'],
            'model' => ['required', 'string', 'max:150'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . $currentYear],
            'price' => ['required', 'numeric', 'min:1'],
            'mileage' => ['required', 'integer', 'min:0'],
            'engine_capacity' => ['required', 'integer', 'min:1', 'max:3000'],
            'transmission' => ['required', 'in:' . implode(',', [
                Motorcycle::TRANSMISSION_MANUAL,
                Motorcycle::TRANSMISSION_AUTOMATIC,
                Motorcycle::TRANSMISSION_SEMI_AUTOMATIC,
            ])],
            'color' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'min:10'],
            'status' => ['required', 'in:' . implode(',', [
                Motorcycle::STATUS_DRAFT,
                Motorcycle::STATUS_PUBLISHED,
                Motorcycle::STATUS_SOLD,
                Motorcycle::STATUS_INACTIVE,
            ])],
            'images' => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => ['file', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'primary_image_index' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Custom Indonesian messages for validation
     */
    public function messages(): array
    {
        return [
            'brand_id.required' => 'Merek motor wajib dipilih.',
            'brand_id.exists' => 'Merek yang dipilih tidak valid.',
            'model.required' => 'Model kendaraan wajib diisi.',
            'year.required' => 'Tahun perakitan wajib diisi.',
            'year.min' => 'Tahun perakitan minimal tahun 1990.',
            'year.max' => 'Tahun perakitan melebihi tahun berjalan.',
            'price.required' => 'Harga motor wajib diisi.',
            'price.min' => 'Harga harus lebih besar dari 0.',
            'mileage.required' => 'Kilometer (odometer) wajib diisi.',
            'mileage.min' => 'Kilometer tidak boleh bernilai negatif.',
            'engine_capacity.required' => 'Kapasitas mesin (cc) wajib diisi.',
            'engine_capacity.min' => 'Kapasitas mesin harus lebih besar dari 0.',
            'transmission.required' => 'Pilihan transmisi wajib ditentukan.',
            'color.required' => 'Warna motor wajib diisi.',
            'description.required' => 'Deskripsi kendaraan wajib diisi.',
            'description.min' => 'Deskripsi kendaraan minimal 10 karakter.',
            'status.required' => 'Status motor wajib dipilih.',
            'images.required' => 'Unggah minimal 1 foto motor.',
            'images.min' => 'Unggah minimal 1 foto motor.',
            'images.max' => 'Maksimal 10 foto per unit motor.',
            'images.*.image' => 'File yang diunggah harus berformat gambar.',
            'images.*.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WebP.',
            'images.*.max' => 'Ukuran setiap foto tidak boleh melebihi 2 MB.',
        ];
    }
}
