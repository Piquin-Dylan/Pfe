@props([
    'key',
    'icon',
    'title',
    'description',
])

<div
    @click="activeFeature = '{{ $key }}'"
    class="cursor-pointer bg-white/5 border border-white/10 rounded-3xl
           p-8 min-h-[340px] h-full flex flex-col
           hover:border-violet-500/70 hover:bg-white/10 hover:-translate-y-2
           transition-all duration-300"
>
    <div
        class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center">
        <img width="60" src="{{ asset($icon) }}" alt="{{ $title }}">
    </div>

    <h3 class="text-white text-xl font-semibold text-center mb-3">
        {{ $title }}
    </h3>

    <p class="text-white/70 text-center text-sm leading-relaxed flex-grow">
        {{ $description }}
    </p>

    <p class="text-[#C5ACEC] text-sm text-center mt-6 font-medium">
        Cliquez pour découvrir →
    </p>
</div>
