@extends('layouts.public')

@section('title', $motorcycle->title . ' - Spesifikasi & Harga')
@section('meta_description', 'Detail spesifikasi motor bekas ' . $motorcycle->title . ', transmisi ' . $motorcycle->transmission . ', jarak tempuh ' . $motorcycle->formatted_mileage . '. Hubungi WhatsApp untuk ketersediaan.')

@section('content')
<!-- BREADCRUMB -->
<div class="bg-slate-50 border-b border-slate-200 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-slate-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1.5 flex-wrap">
                <li><a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a></li>
                <li><span class="text-slate-400">/</span></li>
                <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Katalog</a></li>
                <li><span class="text-slate-400">/</span></li>
                <li><a href="{{ route('catalog.index', ['brand_id' => $motorcycle->brand_id]) }}" class="hover:text-slate-900 transition-colors">{{ $motorcycle->brand->name }}</a></li>
                <li><span class="text-slate-400">/</span></li>
                <li class="font-semibold text-slate-800 truncate max-w-xs" aria-current="page">{{ $motorcycle->model }} ({{ $motorcycle->year }})</li>
            </ol>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12" x-data="{ activeImage: '{{ $motorcycle->main_image_url }}' }">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

        <!-- LEFT COLUMN: FOTO GALERI (55% width on desktop -> 7 cols) -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Main Large Image Container (4:3 aspect ratio) -->
            <div class="relative aspect-[4/3] rounded-2xl border border-slate-200 bg-slate-100 overflow-hidden shadow-card">
                <img
                    :src="activeImage"
                    alt="{{ $motorcycle->title }}"
                    class="w-full h-full object-cover transition-all duration-300"
                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder-motor.svg') }}';"
                >

                <!-- Watermark Badge -->
                <div class="absolute top-4 left-4 flex items-center gap-2">
                    <span class="px-3 py-1 rounded-md text-xs font-bold bg-white/95 text-slate-900 backdrop-blur-sm shadow-sm border border-slate-200">
                        {{ $motorcycle->brand->name }}
                    </span>
                    <x-status-badge :status="$motorcycle->status" />
                </div>

                @if($motorcycle->isSold())
                    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center">
                        <span class="px-6 py-3 rounded-xl bg-brand-red-700 text-white font-extrabold text-xl sm:text-2xl tracking-widest uppercase shadow-lg border border-white/20">
                            UNIT TERJUAL
                        </span>
                    </div>
                @endif
            </div>

            <!-- Thumbnail Carousel / Selector -->
            @if($motorcycle->images->count() > 1)
                <div>
                    <p class="text-xs font-medium text-slate-500 mb-2">Klik foto untuk memperbesar:</p>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                        @foreach($motorcycle->images as $img)
                            <button
                                type="button"
                                @click="activeImage = '{{ $img->url }}'"
                                :class="activeImage === '{{ $img->url }}' ? 'ring-2 ring-brand-green-700 border-transparent' : 'border-slate-200 hover:border-slate-400'"
                                class="aspect-[4/3] rounded-xl overflow-hidden border bg-slate-100 relative focus:outline-none transition-all"
                                aria-label="Lihat foto ke-{{ $loop->iteration }}"
                            >
                                <img
                                    src="{{ $img->url }}"
                                    alt="Foto unit {{ $loop->iteration }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder-motor.svg') }}';"
                                >
                                @if($img->is_primary)
                                    <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-slate-900/80 text-[9px] text-white font-semibold">
                                        Utama
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Trust Verification Banner Under Gallery -->
            <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/60 flex items-start gap-3">
                <svg class="w-5 h-5 text-brand-green-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <div class="text-xs text-emerald-900">
                    <p class="font-bold">Unit Terverifikasi Showroom MuhariMokas</p>
                    <p class="mt-0.5 text-emerald-800 leading-relaxed">
                        Surat-surat resmi (STNK & BPKB) dijamin absah dan bukan motor sengketa. Pembeli berhak memeriksa nomor mesin dan rangka langsung di lokasi.
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: INFORMASI KENDARAAN (45% width on desktop -> 5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Header Title & Price -->
            <div class="pb-6 border-b border-slate-200 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        {{ $motorcycle->brand->name }} &bull; {{ $motorcycle->year }}
                    </span>
                    <x-status-badge :status="$motorcycle->status" />
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $motorcycle->model }}
                </h1>

                <div class="pt-3">
                    <span class="text-xs text-slate-500 font-medium block">Harga Cash Bersih (Nego di Tempat):</span>
                    <span class="text-3xl sm:text-4xl font-extrabold text-brand-red-700 tracking-tight">
                        {{ $motorcycle->formatted_price }}
                    </span>
                </div>
            </div>

            <!-- Specifications Grid -->
            <div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-3">Spesifikasi Kendaraan</h2>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                        <span class="text-[11px] font-medium text-slate-500 uppercase block">Tahun Perakitan</span>
                        <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $motorcycle->year }}</span>
                    </div>
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                        <span class="text-[11px] font-medium text-slate-500 uppercase block">Kilometer (Odometer)</span>
                        <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $motorcycle->formatted_mileage }}</span>
                    </div>
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                        <span class="text-[11px] font-medium text-slate-500 uppercase block">Kapasitas Mesin</span>
                        <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $motorcycle->engine_capacity }} cc</span>
                    </div>
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                        <span class="text-[11px] font-medium text-slate-500 uppercase block">Tipe Transmisi</span>
                        <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $motorcycle->transmission }}</span>
                    </div>
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                        <span class="text-[11px] font-medium text-slate-500 uppercase block">Warna Kendaraan</span>
                        <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $motorcycle->color }}</span>
                    </div>
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50">
                        <span class="text-[11px] font-medium text-slate-500 uppercase block">Kelengkapan Surat</span>
                        <span class="text-sm font-bold text-emerald-700 mt-0.5 block">STNK + BPKB Lengkap</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-2">Deskripsi & Kondisi Fisik</h2>
                <div class="p-4 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $motorcycle->description }}
                </div>
            </div>

            <!-- WHATSAPP CTA ACTION BUTTON (Section 4.5) -->
            <div class="pt-4 border-t border-slate-200">
                @if($motorcycle->isSold())
                    <button
                        type="button"
                        disabled
                        class="w-full py-4 px-6 rounded-xl text-base font-bold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        Unit Telah Terjual (CTA Dinonaktifkan)
                    </button>
                    <p class="text-xs text-center text-slate-500 mt-2">
                        Silakan lihat katalog kami untuk unit sejenis yang masih tersedia.
                    </p>
                @else
                    <a
                        href="{{ $motorcycle->whatsapp_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full py-4 px-6 rounded-xl text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 transition-colors shadow-md flex items-center justify-center gap-3 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600"
                    >
                        <!-- WhatsApp Logo SVG -->
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Hubungi Showroom via WhatsApp
                    </a>
                    <p class="text-[11px] text-center text-slate-500 mt-2">
                        Pesan otomatis berisi nama motor & harga akan otomatis terisi.
                    </p>
                @endif
            </div>

            <!-- Showroom Visit Card -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-xs text-slate-600 space-y-1.5">
                <div class="flex items-center gap-2 font-bold text-slate-900">
                    <svg class="w-4 h-4 text-brand-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Ingin Cek Fisik & Test Ride Langsung?</span>
                </div>
                <p>Kunjungi showroom kami di {{ config('showroom.address') }}. Buka setiap hari kerja 08:30 - 18:00 WIB.</p>
            </div>
        </div>
    </div>

    <!-- RELATED MOTORCYCLES SECTION -->
    @if($relatedMotorcycles->isNotEmpty())
        <div class="mt-16 pt-12 border-t border-slate-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Rekomendasi Motor Lainnya</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Unit sejenis yang mungkin Anda minati</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-xs font-semibold text-brand-green-700 hover:text-brand-green-800">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedMotorcycles as $rel)
                    <x-product-card :motorcycle="$rel" />
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- MOBILE STICKY BOTTOM BAR (Section 4.4) -->
@if(!$motorcycle->isSold())
    <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white border-t border-slate-200 p-3 shadow-modal flex items-center justify-between gap-3">
        <div class="min-w-0">
            <span class="text-[10px] text-slate-500 font-medium block">Harga Cash</span>
            <span class="text-base font-extrabold text-brand-red-700 truncate block">{{ $motorcycle->formatted_price }}</span>
        </div>
        <a
            href="{{ $motorcycle->whatsapp_url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 flex items-center gap-2 shrink-0 shadow-sm"
        >
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            Chat WhatsApp
        </a>
    </div>
@endif
@endsection
