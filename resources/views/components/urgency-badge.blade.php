@props(['urgensi'])

@php
    $urgensi = $urgensi ?: 'Normal';

    $classes = match($urgensi) {
        'Ada risiko keselamatan' => 'bg-rose-50 text-rose-700 border-rose-200',
        'Mendesak' => 'bg-amber-50 text-amber-700 border-amber-200',
        default => 'bg-blue-50 text-blue-700 border-blue-200',
    };

    $icon = match($urgensi) {
        'Ada risiko keselamatan' => 'fa-triangle-exclamation text-rose-500',
        'Mendesak' => 'fa-circle-exclamation text-amber-500',
        default => 'fa-circle-info text-blue-500',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold border {$classes}"]) }}>
    <i class="fa-solid {{ $icon }} text-xs"></i>
    <span>{{ $urgensi }}</span>
</span>
