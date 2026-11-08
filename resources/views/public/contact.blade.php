@extends('layouts.public')

@section('title', 'Kontak & Lokasi Showroom MuhariMokas')
@section('meta_description', 'Hubungi showroom MuhariMokas via WhatsApp atau kunjungi langsung lokasi kami di Jakarta untuk melihat unit dan test ride.')

@section('content')
<!-- HEADER -->
<div class="bg-slate-50 border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-block px-3 py-1 rounded-md text-xs font-bold text-brand-green-700 bg-brand-green-50 border border-brand-green-200 uppercase tracking-wider mb-3">
                Layanan Pelanggan
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kontak & Lokasi Showroom
            </h1>
            <p class="text-base text-slate-600 mt-2 leading-relaxed">
                Kami siap menyambut Anda untuk konsultasi unit, pengecekan fisik kendaraan, hingga test ride di lokasi showroom.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        <!-- CONTACT INFORMATION CARDS -->
        <div class="lg:col-span-5 space-y-6">
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-card space-y-6">
                <h2 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100">
                    Informasi Showroom Utama
                </h2>

                <!-- Alamat Fisik -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="text-xs">
                        <span class="font-bold text-slate-900 block">Alamat Showroom</span>
                        <p class="text-slate-600 mt-0.5 leading-relaxed">{{ config('showroom.address') }}</p>
                    </div>
                </div>

                <!-- Jam Operasional -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-xs">
                        <span class="font-bold text-slate-900 block">Jam Operasional</span>
                        <p class="text-slate-600 mt-0.5">{{ config('showroom.hours') }}</p>
                        <p class="text-emerald-700 font-medium mt-0.5">Minggu / Tanggal Merah: Dengan Konfirmasi Janji Temu</p>
                    </div>
                </div>

                <!-- WhatsApp Direct -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </div>
                    <div class="text-xs">
                        <span class="font-bold text-slate-900 block">WhatsApp Resmi Showroom</span>
                        <p class="text-slate-600 mt-0.5">{{ config('showroom.phone') }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="text-xs">
                        <span class="font-bold text-slate-900 block">Email Informasi</span>
                        <p class="text-slate-600 mt-0.5">{{ config('showroom.email') }}</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-4 border-t border-slate-100">
                    <a
                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('showroom.whatsapp_number')) }}?text={{ rawurlencode('Halo MuhariMokas, saya ingin bertanya seputar unit motor bekas.') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2 shadow-sm"
                    >
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Mulai Obrolan WhatsApp Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT: SHOWROOM LOCATION MAP / PREVIEW -->
        <div class="lg:col-span-7 space-y-4">
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-card space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Peta & Rute Lokasi</h2>
                        <p class="text-xs text-slate-500">Akses mudah di jalan protokol, parkir kendaraan roda 2 dan 4 lega</p>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-brand-green-50 text-brand-green-700 text-xs font-semibold border border-brand-green-200">
                        Lokasi Terbuka
                    </span>
                </div>

                <div class="aspect-[16/9] w-full rounded-xl overflow-hidden border border-slate-200 bg-slate-100 relative">
                    <iframe
                        src="{{ config('showroom.map_embed_url') }}"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Peta Lokasi Showroom MuhariMokas"
                    ></iframe>
                </div>

                <div class="text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-200 flex items-start gap-3">
                    <svg class="w-5 h-5 text-brand-green-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-bold text-slate-900">Petunjuk Arah & Kunjungan:</p>
                        <p class="mt-0.5 leading-relaxed">
                            Showroom terletak sekitar 500 meter dari Halte TransJakarta Otista. Tersedia area test ride yang aman dan alat ukur voltase aki serta kompresi mesin jika Anda ingin melakukan pengetesan langsung di tempat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
