@props(['status'])

<span
    {{ $attributes->class([
        'px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wide border',
        'bg-green-500/20 text-green-400 border-green-500/40' => $status === 'present',
        'bg-red-500/20 text-red-400 border-red-500/40' => $status === 'absent',
        'bg-orange-500/20 text-orange-400 border-orange-500/40' => $status === 'en attente',
    ]) }}
>{{ $status }}</span>
