@props([
    'poste',
    'x',
    'y',
    'image' => null,
])

<div
    class="absolute -translate-x-1/2 -translate-y-1/2 flex flex-col items-center"
    style="left: {{ $x }}%; top: {{ $y }}%;"
>

    @if($image)
        <img
            src="{{ asset('storage/' . $image) }}"
            alt="{{ $poste }}"
            class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-lg"
        >
    @else
        <span class="player_circle"></span>
    @endif

    <span class="text-white text-sm mt-1 text-center font-medium">
        {{ $poste }}
    </span>

</div>
