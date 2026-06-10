@props([
    'image',
    'title',
    'voir',
    'value',
    'link'
])

<article
    class="group relative overflow-hidden rounded-[32px]
           border border-white/10 bg-[#151822]
           p-8 min-h-[260px]
           flex flex-col justify-between
           transition-all duration-300
           hover:-translate-y-1
           hover:border-violet-400/40">

    <div class="absolute inset-0 bg-gradient-to-r from-[#6D5DFC]/10 via-transparent to-transparent"></div>

    <div class="relative z-10 flex flex-col items-center text-center gap-6">

        <div class="w-28 h-28 rounded-3xl bg-[#241F42] border border-[#5B4BDB]/40 flex items-center justify-center">
            <img
                src="{{ $image }}"
                class="w-16 h-16"
                alt="">
        </div>

        <div class="space-y-2">

            <p class="text-white text-3xl font-bold">
                {{ $value }}
            </p>

            <h3 class="text-gray-400 text-lg font-semibold">
                {{ $title }}
            </h3>

        </div>

    </div>

    <a
        href="{{ $link }}"
        class="relative z-10 flex items-center justify-center gap-2
               text-[#8B74FF] font-semibold text-lg
               transition-all duration-300
               group-hover:text-violet-300
               group-hover:translate-x-1">

        {{ $voir }}

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 5l7 7-7 7"/>
        </svg>

    </a>

</article>
