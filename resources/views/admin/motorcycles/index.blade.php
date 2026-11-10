@extends('layouts.admin')

@section('page_title', 'Kelola Inventaris Motor')

@section('content')
<div
    class="space-y-6"
    x-data="{
        deleteModalOpen: false,
        deleteActionUrl: '',
        deleteItemTitle: '',
        exportModalOpen: {{ $errors->hasAny(['from_date', 'to_date']) ? 'true' : 'false' }},
        exportMode: '{{ $errors->hasAny(['from_date', 'to_date']) ? (old('export_type') === 'sales' ? 'sales' : 'arrivals') : '' }}',
        exportAction: '{{ $errors->hasAny(['from_date', 'to_date']) ? (old('export_type') === 'sales' ? route('admin.motorcycles.export.sales') : route('admin.motorcycles.export.arrivals')) : '' }}'
    }"
>

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Inventaris Kendaraan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data spesifikasi, harga, status penjualan, dan foto seluruh unit.</p>
            <p class="text-xs text-amber-700 mt-1">Ekspor penjualan difilter berdasarkan tanggal status motor berubah menjadi terjual.</p>
        </div>

        <div class="flex flex-wrap gap-2 self-start sm:self-auto">
            <button type="button" @click="exportMode = 'sales'; exportAction = '{{ route('admin.motorcycles.export.sales') }}'; exportModalOpen = true" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors" title="Pilih rentang tanggal untuk ekspor motor terjual.">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 12l-4-4m4 4l4-4M4 20h16"/></svg>
                Ekspor Penjualan
            </button>
            <button type="button" @click="exportMode = 'arrivals'; exportAction = '{{ route('admin.motorcycles.export.arrivals') }}'; exportModalOpen = true" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors" title="Pilih rentang tanggal untuk ekspor motor masuk.">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 12l-4-4m4 4l4-4M4 20h16"/></svg>
                Ekspor Motor Masuk
            </button>
            <a href="{{ route('admin.motorcycles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-brand-red-700 hover:bg-brand-red-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Unit Baru
            </a>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR (Section 5.3) -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-card">
        <form action="{{ route('admin.motorcycles.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <!-- Search Keyword -->
            <div class="sm:col-span-5 relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan model, warna, atau deskripsi..."
                    class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-300 text-xs sm:text-sm focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-3">
                <select name="status" class="w-full rounded-xl border border-slate-300 text-xs sm:text-sm py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Tersedia (Published)</option>
                    <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Terjual (Sold)</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Filter Brand -->
            <div class="sm:col-span-3">
                <select name="brand_id" class="w-full rounded-xl border border-slate-300 text-xs sm:text-sm py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700">
                    <option value="">Semua Merek</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset -->
            <div class="sm:col-span-1 flex gap-1">
                <button type="submit" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-colors flex items-center justify-center" title="Filter data">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'brand_id']))
                    <a href="{{ route('admin.motorcycles.index') }}" class="p-2 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-500 transition-colors flex items-center justify-center shrink-0" title="Reset filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- DATA TABLE (Desktop View) & CARD LIST (Mobile View) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-card overflow-hidden">
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="py-3.5 px-6">Foto</th>
                        <th class="py-3.5 px-6">Nama Motor</th>
                        <th class="py-3.5 px-6">Merek</th>
                        <th class="py-3.5 px-6">Tahun</th>
                        <th class="py-3.5 px-6">Harga</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Terakhir Diperbarui</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($motorcycles as $motorcycle)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- 1. Foto -->
                            <td class="py-3.5 px-6">
                                <img
                                    src="{{ $motorcycle->main_image_url }}"
                                    alt="{{ $motorcycle->model }}"
                                    class="w-14 h-10 object-cover rounded-lg border border-slate-200 bg-slate-100"
                                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder-motor.svg') }}';"
                                >
                            </td>

                            <!-- 2. Nama Motor -->
                            <td class="py-3.5 px-6">
                                <a href="{{ route('admin.motorcycles.edit', $motorcycle->id) }}" class="font-bold text-slate-900 hover:text-brand-green-700 transition-colors block">
                                    {{ $motorcycle->model }}
                                </a>
                                <span class="text-xs text-slate-500">{{ $motorcycle->transmission }} &bull; {{ $motorcycle->formatted_mileage }}</span>
                            </td>

                            <!-- 3. Merek -->
                            <td class="py-3.5 px-6 font-medium text-slate-700">
                                {{ $motorcycle->brand->name }}
                            </td>

                            <!-- 4. Tahun -->
                            <td class="py-3.5 px-6 text-slate-600">
                                {{ $motorcycle->year }}
                            </td>

                            <!-- 5. Harga -->
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                {{ $motorcycle->formatted_price }}
                            </td>

                            <!-- 6. Status -->
                            <td class="py-3.5 px-6">
                                <x-status-badge :status="$motorcycle->status" />
                            </td>

                            <!-- 7. Terakhir Diperbarui -->
                            <td class="py-3.5 px-6 text-xs text-slate-500">
                                {{ $motorcycle->updated_at->diffForHumans() }}
                            </td>

                            <!-- 8. Aksi (Preview, Edit, Delete) -->
                            <td class="py-3.5 px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a
                                        href="{{ route('catalog.show', $motorcycle->id) }}"
                                        target="_blank"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                                        title="Pratinjau Halaman Publik"
                                        aria-label="Lihat unit di publik"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a
                                        href="{{ route('admin.motorcycles.edit', $motorcycle->id) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.motorcycles.destroy', $motorcycle->id) }}'; deleteItemTitle = '{{ addslashes($motorcycle->title) }}'"
                                        class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition-colors"
                                        title="Hapus unit"
                                        aria-label="Hapus unit motor"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="max-w-xs mx-auto text-slate-400 space-y-2">
                                    <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p class="text-sm font-bold text-slate-800">Tidak ada unit kendaraan ditemukan</p>
                                    <p class="text-xs text-slate-500">Coba ubah kata kunci filter Anda atau tambahkan unit baru ke inventaris.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (Section 11: Rancang ulang komponen sesuai kebutuhan perangkat) -->
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($motorcycles as $motorcycle)
                <div class="p-4 flex gap-3 items-start">
                    <img
                        src="{{ $motorcycle->main_image_url }}"
                        alt="{{ $motorcycle->model }}"
                        class="w-20 h-16 object-cover rounded-lg border border-slate-200 bg-slate-100 shrink-0"
                    >
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-semibold text-slate-500">{{ $motorcycle->brand->name }} &bull; {{ $motorcycle->year }}</span>
                            <x-status-badge :status="$motorcycle->status" />
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 truncate mt-0.5">{{ $motorcycle->model }}</h4>
                        <p class="text-sm font-bold text-brand-red-700 mt-1">{{ $motorcycle->formatted_price }}</p>

                        <div class="mt-3 flex items-center justify-between pt-2 border-t border-slate-100">
                            <span class="text-[10px] text-slate-400">{{ $motorcycle->updated_at->diffForHumans() }}</span>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.motorcycles.edit', $motorcycle->id) }}" class="px-2.5 py-1 rounded-md text-xs font-semibold text-slate-700 bg-slate-100">
                                    Edit
                                </a>
                                <button
                                    type="button"
                                    @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.motorcycles.destroy', $motorcycle->id) }}'; deleteItemTitle = '{{ addslashes($motorcycle->title) }}'"
                                    class="p-1 rounded-md text-rose-500 hover:bg-rose-50"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-500">
                    Tidak ada unit kendaraan ditemukan.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($motorcycles->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $motorcycles->links() }}
            </div>
        @endif
    </div>

    <div
        x-show="exportModalOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-labelledby="export-modal-title"
        @keydown.escape.window="exportModalOpen = false"
    >
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-modal border border-slate-200 space-y-5" @click.outside="exportModalOpen = false">
            <div>
                <h3 id="export-modal-title" class="text-lg font-bold text-slate-900" x-text="exportMode === 'sales' ? 'Ekspor Data Penjualan' : 'Ekspor Data Motor Masuk'"></h3>
                <p class="text-xs text-slate-500 mt-1" x-text="exportMode === 'sales' ? 'Pilih rentang tanggal motor berubah menjadi terjual.' : 'Pilih rentang tanggal motor ditambahkan ke inventaris.'"></p>
            </div>

            <form :action="exportAction" method="GET" class="space-y-4">
                <input type="hidden" name="export_type" x-model="exportMode">
                <div>
                    <label for="export-from-date" class="block text-xs font-semibold text-slate-700 mb-1.5">Dari tanggal</label>
                    <input id="export-from-date" type="date" name="from_date" value="{{ old('from_date') }}" required class="w-full rounded-xl border border-slate-300 text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none">
                    @error('from_date')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="export-to-date" class="block text-xs font-semibold text-slate-700 mb-1.5">Sampai tanggal</label>
                    <input id="export-to-date" type="date" name="to_date" value="{{ old('to_date') }}" required class="w-full rounded-xl border border-slate-300 text-sm py-2.5 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none">
                    @error('to_date')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <p class="text-[11px] text-slate-500">Tanggal awal dan akhir dihitung inklusif. Motor yang sudah terjual sebelum fitur ini tersedia mungkin belum memiliki tanggal penjualan.</p>
                <div class="flex gap-3 pt-1">
                    <button type="button" @click="exportModalOpen = false" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-brand-green-700 hover:bg-brand-green-800 text-white font-bold text-xs transition-colors shadow-sm">
                        Unduh Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL (Section 5.6) -->
    <div
        x-show="deleteModalOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title"
        @keydown.escape.window="deleteModalOpen = false"
    >
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-modal border border-slate-200 space-y-4" @click.outside="deleteModalOpen = false">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>

            <div class="text-center">
                <h3 id="modal-title" class="text-lg font-bold text-slate-900">Konfirmasi Hapus Unit</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Apakah Anda yakin ingin menghapus unit <strong class="text-slate-900" x-text="deleteItemTitle"></strong>?
                </p>
                <p class="text-[11px] text-rose-600 mt-1">
                    Seluruh file foto terkait di storage server juga akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button
                    type="button"
                    @click="deleteModalOpen = false"
                    class="flex-1 py-2.5 px-4 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors"
                >
                    Batalkan
                </button>
                <form :action="deleteActionUrl" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition-colors shadow-sm"
                    >
                        Ya, Hapus Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
