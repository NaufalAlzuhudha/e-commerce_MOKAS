<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white text-slate-700">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <title>@yield('title', 'Katalog Motor Bekas Berkualitas') - {{ config('showroom.name', 'MuhariMokas') }}</title>
    <meta name="description"
        content="@yield('meta_description', 'Showroom jual beli sepeda motor bekas berkualitas terpercaya. Transparan, bergaransi dokumen lengkap, dan harga terbaik.')">

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-full flex flex-col font-sans antialiased text-slate-700 bg-white" x-data="{ mobileMenuOpen: false }">
    <!-- Skip to main content for Accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 z-50 px-4 py-2 bg-brand-red-700 text-white font-medium rounded-md shadow-md outline-none ring-2 ring-brand-red-700">
        Lewati ke Konten Utama
    </a>

    <!-- Top Announcement Bar (Subtle Brand Trust) -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Showroom Buka Hari Ini (08:30 - 18:00 WIB) &bull; Semua Dokumen STNK & BPKB Terverifikasi
                    Asli</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="tel:{{ preg_replace('/[^0-9]/', '', config('showroom.whatsapp_number')) }}"
                    class="hover:text-white transition-colors flex items-center gap-1.5 focus:outline-none focus:ring-1 focus:ring-slate-400 rounded">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>{{ config('showroom.phone') }}</span>
                </a>
                <span class="text-slate-600 hidden sm:inline">|</span>
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">
                        Panel Admin &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition-colors text-xs">
                        Karyawan Login
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Public Navbar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-sm border-b border-slate-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between"
            aria-label="Navigasi Utama">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}"
                class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-brand-green-700 rounded-lg p-1"
                aria-label="Beranda MuhariMokas">
                <div
                    class="w-10 h-10 rounded-lg bg-brand-green-700 flex items-center justify-center text-white shadow-sm transition-transform group-hover:scale-105">
                    <!-- Motorcycle Icon SVG -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 15V9l4 3 4-3v6" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-xl font-bold tracking-tight text-slate-900 group-hover:text-brand-green-700 transition-colors">
                        Muhari<span class="text-brand-red-700">Mokas</span>
                    </span>
                    <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">
                        Showroom Motor Bekas
                    </span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-green-700 bg-brand-green-50 font-semibold' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    Beranda
                </a>
                <a href="{{ route('catalog.index') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('catalog.*') ? 'text-brand-green-700 bg-brand-green-50 font-semibold' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    Katalog Motor
                </a>
                <a href="{{ route('about') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-brand-green-700 bg-brand-green-50 font-semibold' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('contact') }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'text-brand-green-700 bg-brand-green-50 font-semibold' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    Kontak
                </a>
            </div>

            <!-- Header Action Button -->
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('catalog.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-brand-red-700 hover:bg-brand-red-800 active:bg-brand-red-900 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari Motor
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="md:hidden flex items-center">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 rounded-md text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-green-700"
                    aria-label="Buka menu navigasi" :aria-expanded="mobileMenuOpen">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen" x-cloak
            class="md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg">
            <a href="{{ route('home') }}"
                class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-brand-green-50 text-brand-green-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('catalog.index') }}"
                class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('catalog.*') ? 'bg-brand-green-50 text-brand-green-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                Katalog Motor
            </a>
            <a href="{{ route('about') }}"
                class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-brand-green-50 text-brand-green-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                Tentang Kami
            </a>
            <a href="{{ route('contact') }}"
                class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-brand-green-50 text-brand-green-700 font-semibold' : 'text-slate-700 hover:bg-slate-50' }}">
                Kontak
            </a>
            <div class="pt-3 border-t border-slate-100">
                <a href="{{ route('catalog.index') }}"
                    class="w-full flex items-center justify-center px-4 py-3 rounded-lg text-base font-semibold text-white bg-brand-red-700 hover:bg-brand-red-800 shadow-sm">
                    Jelajahi Semua Motor
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    <!-- Public Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
                <!-- Col 1: About & Brand -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-lg bg-brand-green-700 flex items-center justify-center text-white font-bold">
                            M
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white">
                            Muhari<span class="text-brand-red-600">Mokas</span>
                        </span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                        Showroom jual beli sepeda motor bekas profesional di Karanganyar. Menyediakan unit berkualitas
                        pilihan dengan jaminan keaslian dokumen resmi (STNK, BPKB, Faktur) dan kondisi kendaraan yang
                        transparan.
                    </p>
                    <div class="pt-2 flex items-center gap-3 text-xs text-slate-400">
                        <span
                            class="px-2.5 py-1 rounded bg-slate-800 border border-slate-700 text-slate-300 font-medium">BPKB
                            & STNK Terjamin</span>
                        <span
                            class="px-2.5 py-1 rounded bg-slate-800 border border-slate-700 text-slate-300 font-medium">Bebas
                            Oplosan Mesin</span>
                        <span
                            class="px-2.5 py-1 rounded bg-slate-800 border border-slate-700 text-slate-300 font-medium">Harga
                            Transparan</span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-4">Navigasi Halaman</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-white transition-colors">Katalog
                                Motor Bekas</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang
                                MuhariMokas</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Lokasi &
                                Kontak</a></li>
                        <li><a href="{{ route('login') }}"
                                class="text-slate-400 hover:text-slate-300 transition-colors">Portal Karyawan</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact Showroom -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-4">Kontak & Lokasi</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ config('showroom.address') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ config('showroom.hours') }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>{{ config('showroom.email') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div
                class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} {{ config('showroom.name') }}. Seluruh hak cipta dilindungi.</p>
                <p>Website Showroom Sepeda Motor Bekas &bull; Dikembangkan sebagai Portfolio Full-Stack Developer</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>