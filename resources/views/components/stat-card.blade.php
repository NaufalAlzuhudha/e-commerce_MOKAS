@props([
    'title',
    'value',
    'subtitle' => null,
    'color' => 'slate', // slate, emerald, rose, amber
])

@php
    $colorMap = [
        'emerald' => [
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-200',
            'text' => 'text-emerald-700',
            'icon_bg' => 'bg-emerald-100 text-emerald-700',
        ],
        'rose' => [
            'bg' => 'bg-rose-50',
            'border' => 'border-rose-200',
            'text' => 'text-rose-700',
            'icon_bg' => 'bg-rose-100 text-rose-700',
        ],
        'amber' => [
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-200',
            'text' => 'text-amber-700',
            'icon_bg' => 'bg-amber-100 text-amber-700',
        ],
        'slate' => [
            'bg' => 'bg-white',
            'border' => 'border-slate-200',
            'text' => 'text-slate-900',
            'icon_bg' => 'bg-slate-100 text-slate-700',
        ],
    ][$color] ?? [
        'bg' => 'bg-white',
        'border' => 'border-slate-200',
        'text' => 'text-slate-900',
        'icon_bg' => 'bg-slate-100 text-slate-700',
    ];
@endphp

<div class="p-5 rounded-xl border {{ $colorMap['border'] }} {{ $colorMap['bg'] }} shadow-card flex items-center justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $title }}</p>
        <p class="mt-1 text-2xl sm:text-3xl font-bold {{ $colorMap['text'] }} tracking-tight">{{ $value }}</p>
        @if($subtitle)
            <p class="mt-1 text-xs text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($icon))
        <div class="w-12 h-12 rounded-xl {{ $colorMap['icon_bg'] }} flex items-center justify-center shrink-0">
            {{ $icon }}
        </div>
    @endif
</div>
