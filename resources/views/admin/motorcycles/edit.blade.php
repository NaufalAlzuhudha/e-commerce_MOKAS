@extends('layouts.admin')

@section('page_title', 'Edit Unit: ' . $motorcycle->title)

@section('content')
<div class="space-y-6">
    <!-- Header Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.motorcycles.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors">
            &larr; Kembali ke Daftar Inventaris
        </a>
        <a href="{{ route('catalog.show', $motorcycle->id) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-green-700 hover:underline">
            Lihat Halaman Publik &rarr;
        </a>
    </div>

    <!-- MAIN FORM (Section 5.5 - 2 Column Layout) -->
    <form
        action="{{ route('admin.motorcycles.update', $motorcycle->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start"
        x-data="imageUploader()"
    >
        @csrf
        @method('PUT')

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
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $motorcycle->brand_id) == $brand->id ? 'selected' : '' }}>
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
                        value="{{ old('model', $motorcycle->model) }}"
                        required
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
                        value="{{ old('year', $motorcycle->year) }}"
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
                        value="{{ old('price', (int) $motorcycle->price) }}"
                        step="1"
                        min="1"
                        required
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
                        value="{{ old('mileage', $motorcycle->mileage) }}"
                        min="0"
                        required
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
                        value="{{ old('engine_capacity', $motorcycle->engine_capacity) }}"
                        min="1"
                        max="3000"
                        required
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
                        <option value="Automatic" {{ old('transmission', $motorcycle->transmission) == 'Automatic' ? 'selected' : '' }}>Automatic (Matic)</option>
                        <option value="Manual" {{ old('transmission', $motorcycle->transmission) == 'Manual' ? 'selected' : '' }}>Manual (Kopling)</option>
                        <option value="Semi-Automatic" {{ old('transmission', $motorcycle->transmission) == 'Semi-Automatic' ? 'selected' : '' }}>Semi-Automatic (Bebek)</option>
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
                        value="{{ old('color', $motorcycle->color) }}"
                        required
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
                    class="w-full rounded-xl border {{ $errors->has('description') ? 'border-rose-500' : 'border-slate-300' }} text-sm p-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none leading-relaxed"
                >{{ old('description', $motorcycle->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- KOLOM KANAN: KELOLA FOTO & STATUS (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Card Foto Tersimpan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-card space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">2. Foto Unit Tersimpan</h3>
                    <span class="text-xs text-slate-500">{{ $motorcycle->images->count() }} Foto</span>
                </div>

                @if($motorcycle->images->isNotEmpty())
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($motorcycle->images as $img)
                            <div class="relative aspect-[4/3] rounded-lg overflow-hidden border border-slate-200 bg-slate-100 group">
                                <img src="{{ $img->url }}" class="w-full h-full object-cover">

                                <!-- Primary Badge -->
                                @if($img->is_primary)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded bg-brand-green-700 text-[10px] text-white font-bold shadow">
                                        Foto Utama
                                    </span>
                                @endif

                                <!-- Action Buttons on Hover/Overlay -->
                                <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-2">
                                    @if(!$img->is_primary)
                                        <button
                                            type="button"
                                            onclick="document.getElementById('set-primary-form-{{ $img->id }}').submit()"
                                            class="px-2 py-1 rounded bg-white text-slate-900 text-xs font-semibold hover:bg-slate-100 shadow"
                                            title="Jadikan Foto Utama"
                                        >
                                            Jadikan Utama
                                        </button>
                                    @endif

                                    @if($motorcycle->images->count() > 1)
                                        <button
                                            type="button"
                                            onclick="if(confirm('Hapus foto ini?')) document.getElementById('delete-img-form-{{ $img->id }}').submit()"
                                            class="p-1 rounded bg-rose-600 text-white hover:bg-rose-700 shadow"
                                            title="Hapus Foto"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500">Belum ada foto tersimpan untuk unit ini.</p>
                @endif

                <!-- Upload Foto Tambahan -->
                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Unggah Foto Tambahan
                    </label>
                    <input
                        type="file"
                        name="images[]"
                        multiple
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        @change="handleFiles($event)"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                    >
                    <p class="text-[10px] text-slate-400">Pilih hingga maksimal total 10 foto.</p>

                    <!-- Preview of new files -->
                    <div x-show="previews.length > 0" class="pt-2">
                        <p class="text-[11px] font-semibold text-slate-700 mb-1.5">Foto Baru Siap Diunggah:</p>
                        <div class="grid grid-cols-3 gap-2">
                            <template x-for="(preview, index) in previews" :key="index">
                                <div class="aspect-[4/3] rounded-lg overflow-hidden border border-slate-200 bg-slate-100">
                                    <img :src="preview.url" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Status & Action Buttons -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-card space-y-4">
                <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
                    3. Status Unit & Simpan
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
                        <option value="draft" {{ old('status', $motorcycle->status) === 'draft' ? 'selected' : '' }}>Draft (Belum Dipublikasikan)</option>
                        <option value="published" {{ old('status', $motorcycle->status) === 'published' ? 'selected' : '' }}>Published (Tersedia di Katalog Publik)</option>
                        <option value="sold" {{ old('status', $motorcycle->status) === 'sold' ? 'selected' : '' }}>Sold (Sudah Terjual)</option>
                        <option value="inactive" {{ old('status', $motorcycle->status) === 'inactive' ? 'selected' : '' }}>Inactive (Nonaktif)</option>
                    </select>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2.5">
                    <button
                        type="submit"
                        class="w-full py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-brand-green-700 hover:bg-brand-green-800 transition-colors shadow-sm flex items-center justify-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan Unit
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

    <!-- Hidden Sub-forms for Image Actions (Set Primary & Delete Image) -->
    @foreach($motorcycle->images as $img)
        <form id="set-primary-form-{{ $img->id }}" action="{{ route('admin.images.setPrimary', $img->id) }}" method="POST" class="hidden">
            @csrf
            @method('PATCH')
        </form>

        <form id="delete-img-form-{{ $img->id }}" action="{{ route('admin.images.destroy', $img->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>

@push('scripts')
<script>
    function imageUploader() {
        return {
            previews: [],
            handleFiles(event) {
                const files = event.target.files;
                this.previews = [];
                if (!files) return;

                for (let i = 0; i < files.length; i++) {
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
