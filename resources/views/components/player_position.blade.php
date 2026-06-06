@props([
    'poste',
    'activePoste',
    'x',
    'y',
    'image' => null,
])

@php
    $imageUrl = null;

    if ($image) {
        $imageUrl = $image === 'photos/person.png'
            ? asset($image)
            : asset('storage/' . $image);
    }
@endphp

<div
    class="absolute -translate-x-1/2 -translate-y-1/2 flex flex-col items-center"
    style="left: {{ $x }}%; top: {{ $y }}%;"
>
    @if($image)
        <img
            src="{{ $imageUrl }}"
            alt="{{ $poste }}"
            class="w-14 h-14 rounded-full object-cover shadow-lg transition-all duration-200 border-2"
            :class="selectedPlayer === '{{ $activePoste }}'
                ? 'border-purple-500 ring-2 ring-purple-500'
                : 'border-white'"
        >
    @else
        <span
            class="player_circle border-2 transition-all duration-200"
            :class="selectedPlayer === '{{ $activePoste }}'
                ? 'border-purple-500 ring-2 ring-purple-500'
                : 'border-white'"
        ></span>
    @endif

    <span class="text-white text-sm mt-1 text-center font-medium">
        {{ $poste }}
    </span>
</div>
