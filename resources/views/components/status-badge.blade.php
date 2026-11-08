@props(['status'])

@php
    $status = strtolower($status ?? 'draft');
    $config = match($status) {
        'published' => [
            'label' => 'Tersedia',
            'bg' => 'bg-emerald-50',
            'text' => 'text-emerald-800',
            'border' => 'border-emerald-200',
            'dot' => 'bg-emerald-600',
        ],
        'sold' => [
            'label' => 'Terjual',
            'bg' => 'bg-rose-50',
            'text' => 'text-rose-800',
            'border' => 'border-rose-200',
            'dot' => 'bg-rose-600',
        ],
        'draft' => [
            'label' => 'Draft',
            'bg' => 'bg-slate-100',
            'text' => 'text-slate-700',
            'border' => 'border-slate-300',
            'dot' => 'bg-slate-400',
        ],
        'inactive' => [
            'label' => 'Nonaktif',
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-800',
            'border' => 'border-amber-200',
            'dot' => 'bg-amber-500',
        ],
        default => [
            'label' => ucfirst($status),
            'bg' => 'bg-slate-100',
            'text' => 'text-slate-700',
            'border' => 'border-slate-200',
            'dot' => 'bg-slate-400',
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {$config['bg']} {$config['text']} border {$config['border']}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}" aria-hidden="true"></span>
    <span>{{ $config['label'] }}</span>
</span>
