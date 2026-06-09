@props([
    'url',
    'label',
    'date',
    'title',
    'start',
    'end',
    'address',
    'color' => 'green'
])

<a href="{{ $url }}"
   class="group flex flex-col justify-between
          min-h-[430px]
          bg-gradient-to-br from-[#0f172a] to-[#020617]
          border border-white/10 rounded-3xl p-5 text-white
          transition-all duration-300
          hover:-translate-y-1
          hover:border-{{ $color }}-400/40">

    <span class="text-xs uppercase tracking-widest text-{{ $color }}-400">
        {{ $label }}
    </span>

    <div class="flex flex-col items-center justify-center mt-6">

        <div
            class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white/10 flex flex-col items-center justify-center">

            <span class="text-3xl sm:text-4xl font-bold leading-none">
                {{ \Carbon\Carbon::parse($date)->format('d') }}
            </span>

            <span class="mt-1 text-xs uppercase text-gray-300">
                {{ \Carbon\Carbon::parse($date)->locale('fr')->translatedFormat('F') }}
            </span>

        </div>

        <span class="mt-5 text-lg sm:text-2xl font-semibold text-center">
            {{ $title }}
        </span>

    </div>

    <div class="mt-6 flex flex-col gap-2 text-center">

        <span class="text-base sm:text-lg">
            {{ \Carbon\Carbon::parse($start)->format('H\hi') }}
            -
            {{ \Carbon\Carbon::parse($end)->format('H\hi') }}
        </span>

        <span class="text-gray-300 break-words">
            {{ $address }}
        </span>

    </div>

    <div class="mt-6 flex justify-center">

        <span
            class="inline-flex items-center gap-2 whitespace-nowrap
           font-semibold
           transition-all duration-300
           group-hover:translate-x-1
           text-{{ $color }}-400">

            Voir les détails

            <x-svg />

        </span>

    </div>

</a>
