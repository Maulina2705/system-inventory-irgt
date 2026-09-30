@props([
    'status' => 'ACTIVE',
    'type' => 'asset', // asset, maintenance, borrowing, schedule
])

@php
    $status = strtoupper((string)$status);
    
    $badgeConfig = match ($status) {
        // Asset & General Status
        'ACTIVE' => [
            'label' => 'Aktif (Normal)',
            'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            'dot' => 'bg-emerald-500',
        ],
        'MAINTENANCE' => [
            'label' => 'Maintenance',
            'class' => 'bg-amber-100 text-amber-800 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'dot' => 'bg-amber-500',
        ],
        'DAMAGED' => [
            'label' => 'Rusak',
            'class' => 'bg-rose-100 text-rose-800 border-rose-300 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
            'dot' => 'bg-rose-500',
        ],
        'LOST' => [
            'label' => 'Hilang',
            'class' => 'bg-slate-800 text-white border-slate-900 dark:bg-zinc-800 dark:text-zinc-200 dark:border-zinc-700',
            'dot' => 'bg-slate-400',
        ],
        'RETIRED' => [
            'label' => 'Nonaktif (Pensiun)',
            'class' => 'bg-slate-100 text-slate-700 border-slate-300 dark:bg-slate-900 dark:text-slate-400 dark:border-slate-800',
            'dot' => 'bg-slate-400',
        ],
        'BORROWED' => [
            'label' => 'Sedang Dipinjam',
            'class' => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
            'dot' => 'bg-blue-500',
        ],

        // Maintenance Report Statuses
        'PENDING' => [
            'label' => 'Menunggu Respon',
            'class' => 'bg-amber-100 text-amber-800 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'dot' => 'bg-amber-500',
        ],
        'IN_PROGRESS' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
            'dot' => 'bg-blue-500',
        ],
        'RESOLVED' => [
            'label' => 'Selesai Diperbaiki',
            'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            'dot' => 'bg-emerald-500',
        ],
        'REJECTED' => [
            'label' => 'Ditolak',
            'class' => 'bg-rose-100 text-rose-800 border-rose-300 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
            'dot' => 'bg-rose-500',
        ],

        // Borrowing & Preventive Statuses
        'PENDING_APPROVAL' => [
            'label' => 'Menunggu ACC',
            'class' => 'bg-amber-100 text-amber-800 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'dot' => 'bg-amber-500',
        ],
        'RETURNED' => [
            'label' => 'Dikembalikan',
            'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            'dot' => 'bg-emerald-500',
        ],
        'OVERDUE' => [
            'label' => 'Terlambat / Jatuh Tempo',
            'class' => 'bg-rose-100 text-rose-800 border-rose-300 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
            'dot' => 'bg-rose-500',
        ],
        'UPCOMING' => [
            'label' => 'Akan Datang',
            'class' => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
            'dot' => 'bg-blue-500',
        ],
        'DUE' => [
            'label' => 'Jatuh Tempo (Segera)',
            'class' => 'bg-amber-100 text-amber-800 border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
            'dot' => 'bg-amber-500',
        ],
        'COMPLETED' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
            'dot' => 'bg-emerald-500',
        ],

        default => [
            'label' => $status,
            'class' => 'bg-slate-100 text-slate-800 border-slate-300 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
            'dot' => 'bg-slate-500',
        ],
    };
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeConfig['class'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $badgeConfig['dot'] }}"></span>
    {{ $slot->isNotEmpty() ? $slot : $badgeConfig['label'] }}
</span>
