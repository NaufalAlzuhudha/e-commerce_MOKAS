@extends('layouts.admin')

@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner with Quick Action -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-card flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-brand-green-700">Selamat Bekerja</span>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight mt-0.5">
                Halo, {{ auth()->user()->name }}!
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola status ketersediaan motor, perbarui foto unit, dan pantau stok inventaris showroom.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.motorcycles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-brand-red-700 hover:bg-brand-red-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk Motor
            </a>
            <a href="{{ route('catalog.index') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                Pratinjau Publik
            </a>
        </div>
    </div>

    <!-- SUMMARY STATS CARDS (Section 5.2) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- 1. Total Produk -->
        <x-stat-card
            title="Total Inventaris"
            :value="$stats['total']"
            subtitle="Unit terdata di sistem"
            color="slate"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="5.5" cy="17.5" r="3.5" stroke-width="2" />
                    <circle cx="18.5" cy="17.5" r="3.5" stroke-width="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 6h-3l-2.5 5.5H5.5M15 6l2 5.5h1.5M15 6V4m-3 2l2 5.5" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- 2. Produk Tersedia (Published) -->
        <x-stat-card
            title="Produk Tersedia"
            :value="$stats['published']"
            subtitle="Aktif di katalog publik"
            color="emerald"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- 3. Produk Terjual (Sold) -->
        <x-stat-card
            title="Produk Terjual"
            :value="$stats['sold']"
            subtitle="Unit telah laku ke customer"
            color="rose"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- 4. Produk Draft -->
        <x-stat-card
            title="Produk Draft"
            :value="$stats['draft']"
            subtitle="Menunggu kelengkapan data"
            color="amber"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- RECENT MOTORCYCLES TABLE (Section 5.2) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-card overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Unit Terbaru Ditambahkan</h3>
                <p class="text-xs text-slate-500">6 produk motor terkini dalam sistem showroom</p>
            </div>
            <a href="{{ route('admin.motorcycles.index') }}" class="text-xs font-bold text-brand-green-700 hover:underline">
                Lihat Semua Tabel &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="py-3.5 px-6">Foto</th>
                        <th class="py-3.5 px-6">Unit Motor</th>
                        <th class="py-3.5 px-6">Merek</th>
                        <th class="py-3.5 px-6">Tahun</th>
                        <th class="py-3.5 px-6">Harga Cash</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($recentMotorcycles as $motor)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-6">
                                <img
                                    src="{{ $motor->main_image_url }}"
                                    alt="{{ $motor->model }}"
                                    class="w-14 h-10 object-cover rounded-lg border border-slate-200 bg-slate-100"
                                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder-motor.svg') }}';"
                                >
                            </td>
                            <td class="py-3.5 px-6">
                                <a href="{{ route('admin.motorcycles.edit', $motor->id) }}" class="font-bold text-slate-900 hover:text-brand-green-700 transition-colors block">
                                    {{ $motor->model }}
                                </a>
                                <span class="text-xs text-slate-500">{{ $motor->transmission }} &bull; {{ $motor->formatted_mileage }}</span>
                            </td>
                            <td class="py-3.5 px-6 font-medium text-slate-700">
                                {{ $motor->brand->name }}
                            </td>
                            <td class="py-3.5 px-6 text-slate-600">
                                {{ $motor->year }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                {{ $motor->formatted_price }}
                            </td>
                            <td class="py-3.5 px-6">
                                <x-status-badge :status="$motor->status" />
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        href="{{ route('catalog.show', $motor->id) }}"
                                        target="_blank"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                                        title="Pratinjau publik"
                                        aria-label="Lihat detail publik"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a
                                        href="{{ route('admin.motorcycles.edit', $motor->id) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors"
                                    >
                                        Edit Unit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-xs text-slate-500">
                                Belum ada produk motor terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
