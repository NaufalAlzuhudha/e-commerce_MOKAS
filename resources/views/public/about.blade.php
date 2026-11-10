@extends('layouts.public')

@section('title', 'Tentang Showroom MuhariMokas')
@section('meta_description', 'Profil dan standar integritas showroom MuhariMokas. Menjamin keabsahan surat resmi dan kejujuran kondisi fisik kendaraan bekas.')

@section('content')
<!-- HEADER -->
<div class="bg-slate-50 border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block px-3 py-1 rounded-md text-xs font-bold text-brand-green-700 bg-brand-green-50 border border-brand-green-200 uppercase tracking-wider mb-3">
                Integritas & Kepercayaan
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Tentang Showroom MuhariMokas
            </h1>
            <p class="text-base text-slate-600 mt-2 leading-relaxed">
                Membangun standar baru dalam jual beli motor bekas dengan transparansi mutlak, kelayakan pakai teruji, dan tanpa manipulasi dokumen.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">
    <!-- STORY & PHILOSOPHY -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 space-y-5">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                Membeli Motor Bekas dengan Tenang dan Pasti
            </h2>
            <p class="text-slate-600 text-sm leading-relaxed">
                Banyak calon pembeli motor bekas merasa ragu karena maraknya unit bermasalah, surat bodong, maupun speedometer putaran di pasaran. <strong>MuhariMokas</strong> hadir untuk mengeliminasi kekhawatiran tersebut.
            </p>
            <p class="text-slate-600 text-sm leading-relaxed">
                Kami menerapkan prinsip <em>"Trust Before Decoration"</em>. Bagi kami, kondisi mesin yang orisinal, riwayat pemakaian yang jujur, serta keabsahan BPKB dan STNK jauh lebih berharga daripada polesan kilap permukaan luar semata.
            </p>
            <div class="pt-2 flex flex-wrap gap-3">
                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-semibold">100% Cek Fisik Samsat</span>
                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-semibold">Bebas Bekas Banjir / Tabrakan</span>
                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-semibold">Uji Kelayakan Jalan</span>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 shadow-card space-y-6">
                <h3 class="text-base font-bold text-slate-900">4 Pilar Layanan MuhariMokas</h3>
                <div class="space-y-4 text-xs">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-green-700 text-white flex items-center justify-center font-bold shrink-0">1</span>
                        <div>
                            <p class="font-bold text-slate-900">Legalitas Terverifikasi</p>
                            <p class="text-slate-600 mt-0.5">Semua unit wajib dilengkapi STNK dan BPKB asli yang terdaftar secara sah di kepolisian.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-green-700 text-white flex items-center justify-center font-bold shrink-0">2</span>
                        <div>
                            <p class="font-bold text-slate-900">Mesin Standar Terawat</p>
                            <p class="text-slate-600 mt-0.5">Tidak menerima motor bore-up ekstrem, knalpot bobokan liar, atau komponen vital yang dioplos.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-green-700 text-white flex items-center justify-center font-bold shrink-0">3</span>
                        <div>
                            <p class="font-bold text-slate-900">Test Ride Bebas</p>
                            <p class="text-slate-600 mt-0.5">Calon pembeli berhak menguji tarikan mesin, pengereman, dan handling langsung di area showroom.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-green-700 text-white flex items-center justify-center font-bold shrink-0">4</span>
                        <div>
                            <p class="font-bold text-slate-900">Transaksi Transparan</p>
                            <p class="text-slate-600 mt-0.5">Kuitansi bertanda tangan resmi, materai sah, dan nota serah terima unit yang jelas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- METRICS -->
    <div class="pt-8 border-t border-slate-200">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-6 rounded-xl border border-slate-200 bg-white">
                <p class="text-3xl font-extrabold text-slate-900">{{ $stats['total_verified'] }}</p>
                <p class="text-xs font-semibold text-slate-500 uppercase mt-1">Total Unit Terverifikasi</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 bg-white">
                <p class="text-3xl font-extrabold text-brand-green-700">{{ $stats['sold_count'] }}+</p>
                <p class="text-xs font-semibold text-slate-500 uppercase mt-1">Unit Berhasil Terjual</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 bg-white">
                <p class="text-3xl font-extrabold text-slate-900">{{ $stats['brands_count'] }}</p>
                <p class="text-xs font-semibold text-slate-500 uppercase mt-1">Merek Terkemuka</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 bg-white">
                <p class="text-3xl font-extrabold text-brand-red-700">100%</p>
                <p class="text-xs font-semibold text-slate-500 uppercase mt-1">Dokumen Resmi</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="p-8 rounded-2xl bg-slate-900 text-white text-center space-y-4">
        <h3 class="text-xl font-bold">Siap Menemukan Motor Impian Anda?</h3>
        <p class="text-xs text-slate-300 max-w-md mx-auto">
            Kunjungi katalog kami untuk melihat daftar unit motor bekas yang siap pakai hari ini.
        </p>
        <div>
            <a href="{{ route('catalog.index') }}" class="inline-flex px-6 py-3 rounded-xl text-sm font-bold text-white bg-brand-red-700 hover:bg-brand-red-800 transition-colors">
                Buka Katalog Motor
            </a>
        </div>
    </div>
</div>
@endsection

