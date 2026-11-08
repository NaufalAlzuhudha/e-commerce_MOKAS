@extends('layouts.public')

@section('title', 'Katalog Sepeda Motor Bekas')
@section('meta_description', 'Telusuri koleksi lengkap motor bekas terawat di MuhariMokas. Filter berdasarkan merek, harga, dan tahun dengan jaminan dokumen resmi.')

@section('content')
<!-- BREADCRUMB & HEADER -->
<div class="bg-slate-50 border-b border-slate-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-slate-500 mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1">
                <li><a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a></li>
                <li><span class="text-slate-400">/</span></li>
                <li class="font-semibold text-slate-800" aria-current="page">Katalog Motor</li>
            </ol>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Katalog Sepeda Motor Bekas</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Menampilkan <span class="font-bold text-slate-800">{{ $motorcycles->total() }}</span> unit motor siap jalan.
                </p>
            </div>

            <!-- Active filter badge counters or Reset button -->
            @if(request()->hasAny(['search', 'brand_id', 'min_price', 'max_price', 'min_year', 'max_year', 'transmission', 'include_sold']))
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center self-start sm:self-auto px-3.5 py-1.5 rounded-lg text-xs font-semibold text-brand-red-700 bg-brand-red-50 hover:bg-brand-red-100 border border-brand-red-200 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset Semua Filter
                </a>
            @endif
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ mobileFilterOpen: false }">
    <!-- Top Filter Bar & Search -->
    <div class="mb-6 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
        <!-- Search Input Form -->
        <form action="{{ route('catalog.index') }}" method="GET" class="flex-1 max-w-lg flex items-center relative">
            <!-- Retain active filters as hidden inputs -->
            @foreach(request()->except(['search', 'page']) as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach

            <div class="relative w-full">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari model motor (mis: Vario, Nmax, Beat)..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none transition-colors"
                >
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
            <button type="submit" class="ml-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 transition-colors shrink-0">
                Cari
            </button>
        </form>

        <div class="flex items-center gap-3">
            <!-- Mobile Filter Toggle Button -->
            <button
                type="button"
                @click="mobileFilterOpen = !mobileFilterOpen"
                class="lg:hidden flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors"
            >
                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter Unit
            </button>

            <!-- Sorting Select Dropdown -->
            <form action="{{ route('catalog.index') }}" method="GET" class="flex items-center gap-2">
                @foreach(request()->except(['sort', 'page']) as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach

                <label for="sort" class="text-xs font-medium text-slate-500 hidden sm:inline shrink-0">Urutkan:</label>
                <select
                    name="sort"
                    id="sort"
                    onchange="this.form.submit()"
                    class="py-2.5 pl-3 pr-8 rounded-xl border border-slate-300 bg-white text-xs sm:text-sm font-medium text-slate-700 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none transition-colors"
                >
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru Dipublikasikan</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun: Paling Muda</option>
                    <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Tahun: Paling Tua</option>
                    <option value="mileage_asc" {{ request('sort') == 'mileage_asc' ? 'selected' : '' }}>Kilometer: Terendah</option>
                </select>
            </form>
        </div>
    </div>

    <!-- MAIN GRID LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <!-- DESKTOP FILTER SIDEBAR -->
        <aside class="hidden lg:block lg:col-span-1 bg-white p-5 rounded-2xl border border-slate-200 shadow-card sticky top-24">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Filter Kendaraan</h2>
                <a href="{{ route('catalog.index') }}" class="text-xs font-semibold text-brand-red-700 hover:underline">Reset</a>
            </div>

            <form action="{{ route('catalog.index') }}" method="GET" class="mt-4 space-y-5">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <!-- Filter Merek (Brand) -->
                <div>
                    <label for="brand_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Merek Motor</label>
                    <select name="brand_id" id="brand_id" class="w-full rounded-lg border border-slate-300 text-sm py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700">
                        <option value="">Semua Merek</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }} ({{ $brand->motorcycles_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Transmisi -->
                <div>
                    <label for="transmission" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Transmisi</label>
                    <select name="transmission" id="transmission" class="w-full rounded-lg border border-slate-300 text-sm py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700">
                        <option value="">Semua Transmisi</option>
                        <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic (Matic)</option>
                        <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual (Kopling)</option>
                        <option value="Semi-Automatic" {{ request('transmission') == 'Semi-Automatic' ? 'selected' : '' }}>Semi-Automatic (Bebek)</option>
                    </select>
                </div>

                <!-- Filter Rentang Harga -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Rentang Harga (Rp)</label>
                    <div class="space-y-2">
                        <input
                            type="number"
                            name="min_price"
                            value="{{ request('min_price') }}"
                            placeholder="Min (contoh: 10000000)"
                            step="500000"
                            class="w-full rounded-lg border border-slate-300 text-xs py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700"
                        >
                        <input
                            type="number"
                            name="max_price"
                            value="{{ request('max_price') }}"
                            placeholder="Maks (contoh: 30000000)"
                            step="500000"
                            class="w-full rounded-lg border border-slate-300 text-xs py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700"
                        >
                    </div>
                </div>

                <!-- Filter Rentang Tahun -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Rentang Tahun</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input
                            type="number"
                            name="min_year"
                            value="{{ request('min_year') }}"
                            placeholder="Dari (2018)"
                            min="1990"
                            max="{{ date('Y') + 1 }}"
                            class="w-full rounded-lg border border-slate-300 text-xs py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700"
                        >
                        <input
                            type="number"
                            name="max_year"
                            value="{{ request('max_year') }}"
                            placeholder="Sampai ({{ date('Y') }})"
                            min="1990"
                            max="{{ date('Y') + 1 }}"
                            class="w-full rounded-lg border border-slate-300 text-xs py-2 px-3 focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700"
                        >
                    </div>
                </div>

                <!-- Toggle Tampilkan Unit Terjual (Rekomendasi Open Question #1) -->
                <div class="pt-2 border-t border-slate-100">
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-medium text-slate-700">
                        <input
                            type="checkbox"
                            name="include_sold"
                            value="1"
                            {{ request('include_sold') == '1' ? 'checked' : '' }}
                            class="rounded border-slate-300 text-brand-green-700 focus:ring-brand-green-700"
                        >
                        <span>Sertakan motor yang sudah terjual</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-sm font-bold text-white bg-brand-green-700 hover:bg-brand-green-800 transition-colors shadow-sm">
                    Terapkan Filter
                </button>
            </form>
        </aside>

        <!-- MOBILE FILTER DRAWER -->
        <div x-show="mobileFilterOpen" x-cloak class="lg:hidden fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 max-h-[85vh] overflow-y-auto space-y-4 shadow-modal">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <h3 class="text-base font-bold text-slate-900">Filter Katalog Motor</h3>
                    <button @click="mobileFilterOpen = false" class="text-slate-400 hover:text-slate-700 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('catalog.index') }}" method="GET" class="space-y-4">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Merek</label>
                        <select name="brand_id" class="w-full rounded-lg border border-slate-300 text-sm py-2 px-3">
                            <option value="">Semua Merek</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }} ({{ $brand->motorcycles_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Transmisi</label>
                        <select name="transmission" class="w-full rounded-lg border border-slate-300 text-sm py-2 px-3">
                            <option value="">Semua Transmisi</option>
                            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Semi-Automatic" {{ request('transmission') == 'Semi-Automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Rentang Harga (Rp)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="rounded-lg border border-slate-300 text-xs py-2 px-3">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maks" class="rounded-lg border border-slate-300 text-xs py-2 px-3">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Rentang Tahun</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_year" value="{{ request('min_year') }}" placeholder="Min" class="rounded-lg border border-slate-300 text-xs py-2 px-3">
                            <input type="number" name="max_year" value="{{ request('max_year') }}" placeholder="Maks" class="rounded-lg border border-slate-300 text-xs py-2 px-3">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-medium text-slate-700">
                            <input type="checkbox" name="include_sold" value="1" {{ request('include_sold') == '1' ? 'checked' : '' }} class="rounded border-slate-300 text-brand-green-700">
                            <span>Sertakan motor yang sudah terjual</span>
                        </label>
                    </div>

                    <div class="pt-3 flex gap-2">
                        <a href="{{ route('catalog.index') }}" class="flex-1 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-center text-sm font-semibold">
                            Reset
                        </a>
                        <button type="submit" class="flex-1 py-2.5 rounded-xl bg-brand-green-700 text-white text-center text-sm font-semibold">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PRODUCT GRID (Section 4.2) -->
        <main class="lg:col-span-3">
            @if($motorcycles->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($motorcycles as $motorcycle)
                        <x-product-card :motorcycle="$motorcycle" />
                    @endforeach
                </div>

                <!-- PAGINATION (Preserves filters) -->
                <div class="mt-10">
                    {{ $motorcycles->links() }}
                </div>
            @else
                <!-- EMPTY STATE (Section 12) -->
                <div class="p-12 text-center rounded-2xl border border-slate-200 bg-white shadow-card">
                    <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-slate-900">Tidak ada motor yang cocok dengan pencarian</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Coba ubah kata kunci pencarian, kurangi filter merek, atau atur kembali rentang harga Anda.
                    </p>
                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ route('catalog.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                            Bersihkan Filter
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('showroom.whatsapp_number')) }}?text={{ rawurlencode('Halo MuhariMokas, saya mencari motor yang belum ada di katalog.') }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-brand-green-700 hover:bg-brand-green-800 transition-colors">
                            Tanyakan via WhatsApp
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
