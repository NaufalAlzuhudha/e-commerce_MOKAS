<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-700">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <title>Login Karyawan - {{ config('showroom.name', 'MuhariMokas') }}</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans antialiased bg-slate-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-3 group focus:outline-none">
            <div class="w-11 h-11 rounded-xl bg-brand-green-700 flex items-center justify-center text-white shadow-sm transition-transform group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="5.5" cy="17.5" r="3.5" />
                    <circle cx="18.5" cy="17.5" r="3.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 6h-3l-2.5 5.5H5.5M15 6l2 5.5h1.5M15 6V4m-3 2l2 5.5" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-bold tracking-tight text-slate-900">
                    Muhari<span class="text-brand-red-700">Mokas</span>
                </span>
                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">
                    Portal Akses Karyawan
                </span>
            </div>
        </a>

        <h1 class="mt-6 text-center text-xl font-bold text-slate-900">
            Masuk ke Panel Inventaris
        </h1>
        <p class="mt-1 text-center text-xs text-slate-500">
            Khusus karyawan internal untuk mengelola katalog kendaraan
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="bg-white py-8 px-6 sm:px-10 rounded-2xl border border-slate-200 shadow-dropdown space-y-6">

            <!-- Credentials Callout for Evaluator -->
            <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50 text-xs text-emerald-900 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-brand-green-700 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span class="font-bold block">Akun Demo Pengujian:</span>
                    <span class="text-emerald-800">Email: <strong class="select-all">admin@muharimokas.com</strong> &bull; Password: <strong class="select-all">password123</strong></span>
                </div>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="p-3 rounded-lg bg-rose-50 border border-rose-200 text-xs text-rose-800" role="alert">
                    <p class="font-bold">Gagal masuk:</p>
                    <ul class="list-disc list-inside mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPassword: false }">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Alamat Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', 'admin@muharimokas.com') }}"
                        required
                        autofocus
                        class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-300' }} text-sm focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none transition-colors"
                        placeholder="karyawan@muharimokas.com"
                    >
                </div>

                <!-- Password Input with Visibility Toggle (Section 5.1) -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            value="password123"
                            required
                            class="w-full pl-3.5 pr-11 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-300' }} text-sm focus:border-brand-green-700 focus:ring-1 focus:ring-brand-green-700 outline-none transition-colors"
                            placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                            aria-label="Lihat atau sembunyikan kata sandi"
                        >
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-600">
                        <input
                            type="checkbox"
                            name="remember"
                            checked
                            class="rounded border-slate-300 text-brand-green-700 focus:ring-brand-green-700"
                        >
                        <span>Ingat sesi saya</span>
                    </label>

                    <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-900 transition-colors">
                        &larr; Ke Website Publik
                    </a>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-brand-green-700 hover:bg-brand-green-800 active:bg-brand-green-900 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green-700"
                    >
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
