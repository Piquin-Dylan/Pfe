@props([
    'title',
    'subtitle' => null,
    'closeAction'
])

<div class="flex items-center justify-between mb-8">

    <div>
        <h2 class="text-2xl font-bold text-white">
            {{ $title }}
        </h2>

        @if($subtitle)
            <p class="text-slate-400 mt-1">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    <button
        wire:click="{{ $closeAction }}"
        class="text-slate-400 hover:text-white text-3xl leading-none transition">
        ×
    </button>

</div>
