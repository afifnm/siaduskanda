@props(['status'])

@php
    $classes = match($status) {
        'masuk' => 'bg-amber-50 text-amber-800 border-amber-300/80',
        'terverifikasi' => 'bg-blue-50 text-blue-800 border-blue-300/80',
        'dalam_proses' => 'bg-purple-50 text-purple-800 border-purple-300/80',
        'menunggu_konfirmasi' => 'bg-teal-50 text-teal-800 border-teal-300/80',
        'selesai' => 'bg-emerald-50 text-emerald-800 border-emerald-300/80',
        'ditolak' => 'bg-rose-50 text-rose-800 border-rose-300/80',
        default => 'bg-slate-50 text-slate-800 border-slate-300/80',
    };

    $dotColor = match($status) {
        'masuk' => 'bg-amber-500',
        'terverifikasi' => 'bg-blue-600',
        'dalam_proses' => 'bg-purple-600',
        'menunggu_konfirmasi' => 'bg-teal-600',
        'selesai' => 'bg-emerald-600',
        'ditolak' => 'bg-rose-600',
        default => 'bg-slate-500',
    };

    $labels = [
        'masuk' => 'Menunggu Verifikasi',
        'terverifikasi' => 'Terverifikasi (Ditugaskan)',
        'dalam_proses' => 'Sedang Ditangani',
        'menunggu_konfirmasi' => 'Menunggu Review Selesai',
        'selesai' => 'Selesai Tuntas',
        'ditolak' => 'Ditolak',
    ];

    $label = $labels[$status] ?? ucfirst(str_replace('_', ' ', $status));
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-bold border {$classes} uppercase tracking-wider"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    <span>{{ $label }}</span>
</span>
