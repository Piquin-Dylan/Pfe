@props([
    'href',
    'color' => 'blue',
    'title',
])

<a
    href="{{ $href }}"
    class="group flex flex-col justify-between
           h-full min-h-[250px]
           bg-gradient-to-br from-[#0f172a] to-[#020617]
           border border-white/10 rounded-3xl p-5 text-white">

    <span class="text-xs uppercase tracking-widest text-{{ $color }}-400">
        {{ $title }}
    </span>

    {{ $slot }}

    <div class="mt-5 flex justify-center">
        <span
            class="inline-flex items-center gap-2 whitespace-nowrap
       text-{{ $color }}-400 font-semibold
       transition-all duration-300
       group-hover:text-{{ $color }}-300
       group-hover:translate-x-1">

            Voir les détails

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </span>
    </div>

</a>
