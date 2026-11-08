@extends('layouts.admin')

@section('page_title', 'Tambah Unit Motor Baru')

@section('content')
<div class="space-y-6">
    <!-- Header Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.motorcycles.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            &larr; Kembali ke Daftar Inventaris
        </a>
    </div>

    <!-- MAIN FORM (Section 5.4 - 2 Column Layout) -->
    <form
        action="{{ route('admin.motorcycles.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start"
        x-data="imageUploader()"
    >
        @csrf

        <!-- KOLOM KIRI: INFORMASI SPESIFIKASI KENDARAAN (7 Cols) -->
        <div class="lg:col-span-7 space-y-6 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-card">
            <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
                1. Informasi Dasar & Spesifikasi Mesin
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Merek (Brand) -->
                <div>
                    <label for="brand_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Merek Motor <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="brand_id"
                        id="brand_id"
                        required
                        class="w-full rounded-xl border {{ $errors->has('brand_id') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                        <option value="">Pilih Merek Motor</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="model" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Model / Tipe Motor <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="model"
                        id="model"
                        value="{{ old('model') }}"
                        required
                        placeholder="Contoh: Vario 160 ABS, NMAX 155"
                        class="w-full rounded-xl border {{ $errors->has('model') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                    @error('model')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun -->
                <div>
                    <label for="year" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tahun Perakitan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="year"
                        id="year"
                        value="{{ old('year', date('Y')) }}"
                        min="1990"
                        max="{{ date('Y') + 1 }}"
                        required
                        class="w-full rounded-xl border {{ $errors->has('year') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                    @error('year')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Cash -->
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Harga Jual Cash (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        value="{{ old('price') }}"
                        step="100000"
                        min="1"
                        required
                        placeholder="Contoh: 18500000"
                        class="w-full rounded-xl border {{ $errors->has('price') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                    @error('price')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kilometer -->
                <div>
                    <label for="mileage" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kilometer Odometer (km) <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="mileage"
                        id="mileage"
                        value="{{ old('mileage') }}"
                        min="0"
                        required
                        placeholder="Contoh: 14500"
                        class="w-full rounded-xl border {{ $errors->has('mileage') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                    @error('mileage')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas Mesin (cc) -->
                <div>
                    <label for="engine_capacity" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kapasitas Mesin (cc) <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="engine_capacity"
                        id="engine_capacity"
                        value="{{ old('engine_capacity', 150) }}"
                        min="1"
                        max="3000"
                        required
                        placeholder="Contoh: 110, 150, 160, 250"
                        class="w-full rounded-xl border {{ $errors->has('engine_capacity') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                    @error('engine_capacity')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transmisi -->
                <div>
                    <label for="transmission" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tipe Transmisi <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="transmission"
                        id="transmission"
                        required
                        class="w-full rounded-xl border {{ $errors->has('transmission') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                        <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic (Matic)</option>
                        <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual (Kopling)</option>
                        <option value="Semi-Automatic" {{ old('transmission') == 'Semi-Automatic' ? 'selected' : '' }}>Semi-Automatic (Bebek)</option>
                    </select>
                    @error('transmission')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div>
                    <label for="color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Warna Kendaraan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="color"
                        id="color"
                        value="{{ old('color') }}"
                        required
                        placeholder="Contoh: Hitam Doff, Putih Mutiara"
                        class="w-full rounded-xl border {{ $errors->has('color') ? 'border-rose-500' : 'border-slate-300' }} text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                    >
                    @error('color')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi & Kondisi -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Deskripsi Lengkap & Status Kelengkapan Dokumen <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="6"
                    required
                    placeholder="Sebutkan detail kondisi mesin, kelistrikan, masa berlaku pajak STNK, status BPKB/Faktur, dan jumlah kunci cadangan..."
                    class="w-full rounded-xl border {{ $errors->has('description') ? 'border-rose-500' : 'border-slate-300' }} text-sm p-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none leading-relaxed"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- KOLOM KANAN: UPLOAD FOTO & STATUS PUBLIKASI (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Card Upload Foto -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-card space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">2. Foto Unit Kendaraan</h3>
                    <span class="text-xs text-slate-500">Maks. 10 Foto (@ 2MB)</span>
                </div>

                <!-- Drag-and-drop / File Select Zone -->
                <div class="relative border-2 border-dashed border-slate-300 hover:border-brand-green-700 rounded-xl p-6 text-center transition-colors bg-slate-50/60">
                    <input
                        type="file"
                        name="images[]"
                        id="images"
                        multiple
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        required
                        @change="handleFiles($event)"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >
                    <div class="space-y-2 pointer-events-none">
                        <svg class="w-8 h-8 mx-auto text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs font-semibold text-slate-700">Pilih atau seret foto motor ke sini</p>
                        <p class="text-[10px] text-slate-400">Format: JPG, JPEG, PNG, WebP (Maksimal 2 MB per file)</p>
                    </div>
                </div>
                @error('images')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror

                <!-- Live Client-side Image Previews & Primary Selector -->
                <div x-show="previews.length > 0" class="space-y-3 pt-2">
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Pratinjau Foto & Pilih Foto Utama (Thumbnail):
                    </p>
                    <div class="grid grid-cols-3 gap-2.5">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="relative aspect-[4/3] rounded-lg overflow-hidden border border-slate-200 bg-slate-100 group">
                                <img :src="preview.url" class="w-full h-full object-cover">

                                <!-- Primary Selector Radio Overlay -->
                                <label class="absolute top-1.5 left-1.5 cursor-pointer bg-slate-900/75 hover:bg-slate-900 text-white rounded px-1.5 py-0.5 text-[10px] flex items-center gap-1 shadow">
                                    <input
                                        type="radio"
                                        name="primary_image_index"
                                        :value="index"
                                        x-model="primaryIndex"
                                        class="w-3 h-3 text-brand-green-700"
                                    >
                                    <span x-text="primaryIndex == index ? 'Utama' : 'Jadikan Utama'"></span>
                                </label>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Card Status & Action Buttons -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-card space-y-4">
                <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
                    3. Status & Publikasi
                </h3>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Status Kendaraan <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="status"
                        required
                        class="w-full rounded-xl border border-slate-300 text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700"
                    >
                        <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft (Belum Dipublikasikan)</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Tersedia di Katalog Publik)</option>
                        <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold (Sudah Terjual)</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (Nonaktif)</option>
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">
                        Pilih <strong>Draft</strong> jika data belum lengkap, atau langsung <strong>Published</strong> agar tampil di katalog.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2.5">
                    <button
                        type="submit"
                        class="w-full py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-brand-green-700 hover:bg-brand-green-800 transition-colors shadow-sm flex items-center justify-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Unit Kendaraan
                    </button>
                    <a
                        href="{{ route('admin.motorcycles.index') }}"
                        class="w-full py-2.5 px-4 rounded-xl text-center text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors"
                    >
                        Batalkan
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function imageUploader() {
        return {
            previews: [],
            primaryIndex: 0,
            handleFiles(event) {
                const files = event.target.files;
                this.previews = [];
                if (!files) return;

                const maxFiles = Math.min(files.length, 10);
                for (let i = 0; i < maxFiles; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')) {
                        const url = URL.createObjectURL(file);
                        this.previews.push({ url, file });
                    }
                }
            }
        };
    }
</script>
@endpush
@endsection
