@extends('layouts.public')

@section('title', 'Showroom Sepeda Motor Bekas Berkualitas & Terpercaya')
@section('meta_description', 'Beli motor bekas berkualitas di MuhariMokas. Seluruh unit lengkap dengan BPKB dan STNK resmi, mesin halus standar, dan harga transparan.')

@section('content')
<!-- HERO SECTION -->
<section class="relative bg-gradient-to-b from-slate-50 to-white border-b border-slate-200 overflow-hidden py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-brand-green-700 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-brand-green-700"></span>
                    <span>Showroom Motor Bekas Bergaransi Dokumen Resmi</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Temukan Motor Bekas Berkualitas dengan <span class="text-brand-red-700">Harga Terbaik</span>.
                </h1>

                <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
                    Setiap unit motor di <strong>MuhariMokas</strong> melalui pemeriksaan kondisi fisik, mesin original standar pabrik, serta kelengkapan dokumen resmi (STNK & BPKB) yang transparan dan dapat dibuktikan.
                </p>

                <!-- Search / Quick Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row gap-3 sm:items-center">
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center justify-center px-6 py-3.5 rounded-xl text-base font-bold text-white bg-brand-red-700 hover:bg-brand-red-800 active:bg-brand-red-900 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Jelajahi Katalog Motor
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('showroom.whatsapp_number')) }}?text={{ rawurlencode('Halo MuhariMokas, saya ingin tanya ketersediaan motor bekas di showroom.') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-6 py-3.5 rounded-xl text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-slate-400">
                        <!-- WhatsApp Logo SVG -->
                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                </div>

                <!-- Verified Stats Badges -->
                <div class="pt-6 border-t border-slate-200 grid grid-cols-3 gap-4 max-w-lg">
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $stats['total_units'] }}+</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Unit Siap Pakai</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-brand-green-700">100%</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">STNK & BPKB Asli</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $stats['sold_units'] }}+</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Unit Terjual</p>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none rounded-2xl border border-slate-200 bg-white p-3 shadow-dropdown">
                    @if($featuredMotorcycles->isNotEmpty())
                        <img
                            src="{{ $featuredMotorcycles->first()->main_image_url }}"
                            alt="{{ $featuredMotorcycles->first()->title }}"
                            class="w-full aspect-[4/3] object-cover rounded-xl"
                        >
                        <div class="p-4 bg-slate-50 rounded-xl mt-3 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-500 font-medium">Unit Rekomendasi Hari Ini</span>
                                <p class="text-base font-bold text-slate-900">{{ $featuredMotorcycles->first()->title }}</p>
                            </div>
                            <span class="text-base font-bold text-brand-red-700">{{ $featuredMotorcycles->first()->formatted_price }}</span>
                        </div>
                    @else
                        <img src="{{ asset('images/placeholder-motor.svg') }}" alt="Showroom MuhariMokas" class="w-full aspect-[4/3] object-cover rounded-xl">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TRUST HIGHLIGHTS (Prinsip 1: Trust Before Decoration) -->
<section class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Highlight 1 -->
            <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-brand-green-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Dokumen STNK & BPKB Asli</h2>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">Seluruh nomor rangka dan nomor mesin dicek kesesuaiannya dengan Samsat resmi.</p>
                </div>
            </div>

            <!-- Highlight 2 -->
            <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-brand-green-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Mesin Standar Tanpa Oplosan</h2>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">Blok mesin kering, halus, bebas rembes oli, dan tanpa modifikasi jeroan berbahaya.</p>
                </div>
            </div>

            <!-- Highlight 3 -->
            <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-brand-green-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Kondisi Transparan</h2>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">Informasi minus lecet bodi dan riwayat kilometer disampaikan jujur apa adanya.</p>
                </div>
            </div>

            <!-- Highlight 4 -->
            <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-brand-green-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Harga Cash Pasti</h2>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">Tanpa biaya tersembunyi. Pembayaran cash atau transfer aman langsung di showroom.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BRAND EXPLORER -->
<section class="py-10 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Pilih Berdasarkan Merek</h2>
                <p class="text-xs text-slate-500">Temukan unit motor bekas dari produsen terkemuka</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-xs font-semibold text-brand-green-700 hover:text-brand-green-800">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            @foreach($brands as $brand)
                <a
                    href="{{ route('catalog.index', ['brand_id' => $brand->id]) }}"
                    class="p-4 rounded-xl bg-white border border-slate-200 hover:border-brand-green-700 hover:shadow-card transition-all flex items-center justify-between group"
                >
                    <span class="text-sm font-bold text-slate-900 group-hover:text-brand-green-700 transition-colors">
                        {{ $brand->name }}
                    </span>
                    <span class="text-xs font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-600 group-hover:bg-brand-green-50 group-hover:text-brand-green-700">
                        {{ $brand->motorcycles_count }} unit
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURED MOTORCYCLES (Section 4.1 #4) -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-1 text-xs font-semibold uppercase tracking-wider text-brand-green-700 mb-1">
                    <span>Inventaris Pilihan</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Koleksi Motor Terbaru Tersedia
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Unit motor bekas terawat yang siap dipinang hari ini.
                </p>
            </div>

            <a href="{{ route('catalog.index') }}" class="inline-flex items-center text-sm font-bold text-brand-red-700 hover:text-brand-red-800 transition-colors">
                Lihat Seluruh Katalog Motor ({{ $stats['total_units'] }}) &rarr;
            </a>
        </div>

        @if($featuredMotorcycles->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredMotorcycles as $motorcycle)
                    <x-product-card :motorcycle="$motorcycle" />
                @endforeach
            </div>
        @else
            <!-- Empty state -->
            <div class="p-12 text-center rounded-2xl border border-dashed border-slate-300 bg-slate-50">
                <svg class="w-12 h-12 mx-auto text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <h3 class="mt-4 text-base font-bold text-slate-900">Belum ada unit motor yang dipublikasikan</h3>
                <p class="text-xs text-slate-500 mt-1">Silakan kunjungi kembali beberapa saat lagi atau hubungi admin kami.</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA BANNER (Section 4.1 #5) -->
<section class="py-12 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 sm:p-12 border border-slate-700 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-3 text-center md:text-left">
                <span class="inline-block px-3 py-1 rounded bg-brand-green-700/40 text-emerald-300 text-xs font-semibold border border-brand-green-700/60">
                    Layanan Konsultasi Langsung
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Belum Menemukan Motor yang Anda Cari?
                </h2>
                <p class="text-slate-300 text-sm max-w-xl">
                    Katakan pada kami model, tahun, atau anggaran yang Anda inginkan. Tim MuhariMokas akan membantu mencarikan unit terbaik yang sesuai preferensi Anda.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 shrink-0 w-full md:w-auto">
                <a href="{{ route('catalog.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold bg-white text-slate-900 hover:bg-slate-100 transition-colors text-center">
                    Cari di Katalog
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('showroom.whatsapp_number')) }}?text={{ rawurlencode('Halo MuhariMokas, saya sedang mencari motor bekas dengan kriteria tertentu. Bisa dibantu?') }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors text-center inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    Tanya Ketersediaan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT COMPANY PREVIEW (Section 4.1 #6) -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-semibold uppercase tracking-wider text-brand-green-700">Tentang Showroom</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Komitmen Transparansi di MuhariMokas
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Berdiri dengan fokus pada kepuasan dan ketenangan calon pembeli, MuhariMokas menolak segala praktik manipulasi seperti odometer putaran, dokumen palsu, atau mesin bermasalah yang disamarkan.
                </p>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Setiap calon pembeli dipersilakan melakukan test ride dan membawa mekanik kepercayaan sendiri ke showroom kami untuk memeriksa unit hingga benar-benar puas sebelum melakukan pembayaran.
                </p>
                <div class="pt-2">
                    <a href="{{ route('about') }}" class="inline-flex items-center text-sm font-bold text-brand-green-700 hover:text-brand-green-800">
                        Pelajari Profil & Nilai Kami &rarr;
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <p class="text-3xl font-extrabold text-slate-900">100%</p>
                    <p class="text-xs text-slate-600 font-medium mt-1">Dokumen Legal Terjamin</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <p class="text-3xl font-extrabold text-brand-green-700">0%</p>
                    <p class="text-xs text-slate-600 font-medium mt-1">Biaya Tersembunyi</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <p class="text-3xl font-extrabold text-brand-red-700">Siap</p>
                    <p class="text-xs text-slate-600 font-medium mt-1">Test Ride di Tempat</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <p class="text-3xl font-extrabold text-slate-900">Resmi</p>
                    <p class="text-xs text-slate-600 font-medium mt-1">Kwitansi & Materai Asli</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

