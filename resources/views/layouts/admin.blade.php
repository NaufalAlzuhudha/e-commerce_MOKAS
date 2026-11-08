<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-700">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Panel Karyawan {{ config('showroom.name', 'MuhariMokas') }}</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full flex overflow-hidden font-sans antialiased text-slate-700 bg-slate-50" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

    <!-- Admin Sidebar (Desktop & Mobile Drawer) -->
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-200 ease-in-out lg:static lg:inset-auto lg:translate-x-0 shrink-0 border-r border-slate-800"
        aria-label="Sidebar Navigasi Admin"
    >
        <!-- Logo Area -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-brand-green-700 flex items-center justify-center text-white font-bold shadow-sm">
                    M
                </div>
                <div class="flex flex-col">
                    <span class="text-base font-bold text-white tracking-tight">Muhari<span class="text-brand-red-600">Mokas</span></span>
                    <span class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">Panel Karyawan</span>
                </div>
            </a>
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none" aria-label="Tutup sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto" aria-label="Menu Admin">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-green-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Ringkasan Dashboard</span>
            </a>

            <a href="{{ route('admin.motorcycles.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.motorcycles.index') || request()->routeIs('admin.motorcycles.edit') ? 'bg-brand-green-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="5.5" cy="17.5" r="3.5" stroke-width="2" />
                    <circle cx="18.5" cy="17.5" r="3.5" stroke-width="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 6h-3l-2.5 5.5H5.5M15 6l2 5.5h1.5M15 6V4m-3 2l2 5.5" />
                </svg>
                <span>Kelola Inventaris Motor</span>
            </a>

            <a href="{{ route('admin.motorcycles.create') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.motorcycles.create') ? 'bg-brand-green-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Unit Baru</span>
            </a>

            <div class="pt-6 pb-2">
                <span class="px-3.5 text-[10px] uppercase font-bold tracking-wider text-slate-500">Shortcut Publik</span>
            </div>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Website Showroom</span>
                </span>
                <span class="text-xs text-slate-500">&nearr;</span>
            </a>
        </nav>

        <!-- Current User Profile & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-white font-semibold text-xs shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Karyawan' }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 rounded-md text-slate-400 hover:text-brand-red-500 hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-red-700" title="Keluar dari sistem" aria-label="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-label="Buka navigasi sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-bold text-slate-900 truncate">
                    @yield('page_title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.motorcycles.create') }}" class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-brand-red-700 hover:bg-brand-red-800 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-red-700">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Unit
                </a>
                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Showroom Online
                </span>
            </div>
        </header>

        <!-- Flash Toast Notification -->
        @if(session('success'))
            <div class="mx-4 sm:mx-6 lg:mx-8 mt-4 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1">
                    <span class="sr-only">Tutup</span>
                    &times;
                </button>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="mx-4 sm:mx-6 lg:mx-8 mt-4 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 shadow-sm" role="alert">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">
                        <p>{{ session('error') ?? 'Terdapat kesalahan pada input form Anda:' }}</p>
                        @if($errors->any())
                            <ul class="list-disc list-inside mt-1.5 text-xs text-rose-700 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Scrollable Content Viewport -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
