@props(['motorcycle'])

<article class="group bg-white rounded-xl border border-slate-200 overflow-hidden shadow-card hover:shadow-dropdown hover:border-slate-300 transition-all duration-200 flex flex-col">
    <!-- Image Thumbnail (4:3 aspect ratio) -->
    <a href="{{ route('catalog.show', $motorcycle->id) }}" class="relative aspect-[4/3] bg-slate-100 overflow-hidden block">
        <img
            src="{{ $motorcycle->main_image_url }}"
            alt="{{ $motorcycle->title }}"
            loading="lazy"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            onerror="this.onerror=null; this.src='{{ asset('images/placeholder-motor.svg') }}';"
        >

        <!-- Brand Watermark Pill -->
        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-xs font-semibold bg-white/90 text-slate-800 backdrop-blur-sm shadow-sm border border-slate-200/50">
            {{ $motorcycle->brand->name ?? 'Motor' }}
        </span>

        <!-- Sold Out Badge Overlay if Sold -->
        @if($motorcycle->isSold())
            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-brand-red-700 text-white shadow-sm">
                TERJUAL
            </span>
        @endif
    </a>

    <!-- Card Content -->
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div>
            <!-- Model Name & Year -->
            <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-green-700 transition-colors line-clamp-1">
                <a href="{{ route('catalog.show', $motorcycle->id) }}">
                    {{ $motorcycle->model }}
                </a>
            </h3>

            <!-- Specifications Meta (Year, Mileage, Transmission) -->
            <div class="mt-2 flex items-center flex-wrap gap-y-1 gap-x-3 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1 font-medium text-slate-600">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $motorcycle->year }}
                </span>
                <span class="text-slate-300">&bull;</span>
                <span class="inline-flex items-center gap-1 font-medium text-slate-600">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    {{ $motorcycle->formatted_mileage }}
                </span>
                <span class="text-slate-300">&bull;</span>
                <span class="inline-flex items-center gap-1 font-medium text-slate-600">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    {{ $motorcycle->transmission }}
                </span>
            </div>
        </div>

        <!-- Price & Action Section -->
        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider block">Harga Cash</span>
                <span class="text-lg font-bold text-slate-900 tracking-tight text-brand-red-700">
                    {{ $motorcycle->formatted_price }}
                </span>
            </div>

            <a
                href="{{ route('catalog.show', $motorcycle->id) }}"
                class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-brand-green-700 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-brand-green-700"
                aria-label="Lihat spesifikasi {{ $motorcycle->title }}"
            >
                Lihat Detail &rarr;
            </a>
        </div>
    </div>
</article>

