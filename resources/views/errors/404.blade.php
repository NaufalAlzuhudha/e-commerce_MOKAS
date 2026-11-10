@extends('layouts.public')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="w-20 h-20 rounded-2xl bg-slate-100 border border-slate-200 text-slate-400 mx-auto flex items-center justify-center shadow-card">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>

        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-brand-red-700">Kode Kesalahan 404</span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Halaman Tidak Ditemukan</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                Unit kendaraan atau tautan yang Anda tuju mungkin sudah tidak tersedia, dipindahkan, atau status unit belum dipublikasikan.
            </p>
        </div>

        <div class="pt-2 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                &larr; Kembali ke Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-brand-green-700 hover:bg-brand-green-800 transition-colors shadow-sm">
                Buka Katalog Motor
            </a>
        </div>
    </div>
</div>
@endsection

