<div
    x-show="{{ $show }}"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
    style="display: none;">

    <div
        @click.away="{{ $close }}"
        class="relative w-full max-w-md lg:max-w-2xl max-h-[90vh] overflow-y-auto rounded-[2rem] border border-white/20 bg-[#141B34] px-4 py-6 sm:px-8 sm:py-8 shadow-[0_0_80px_rgba(79,70,229,0.15)]">

        <button
            @click="{{ $close }}"
            class="absolute right-4 top-4 text-3xl sm:text-5xl font-light text-white transition hover:scale-110">
            ×
        </button>

        <h2 class="pb-8 sm:pb-12 text-center text-2xl sm:text-3xl font-black text-white">
            {{ $title ?? 'Résultat du match' }}
        </h2>

        <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-10 pb-10 sm:pb-14">

            <div class="flex flex-col items-center gap-4 sm:gap-6">
                <img
                    class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                    src="{{ asset('storage/' . $homeLogo) }}"
                    alt="{{ $homeName }}"
                >

                <span class="text-center text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white">
                    {{ $homeName }}
                </span>
            </div>

            <div class="flex items-center gap-2 sm:gap-4 md:gap-6">
                {{ $slot }}
            </div>

            <div class="flex flex-col items-center gap-4 sm:gap-6">
                <img
                    class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                    src="{{ asset('storage/' . $awayLogo) }}"
                    alt="{{ $awayName }}"
                >

                <span class="text-center text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white">
                    {{ $awayName }}
                </span>
            </div>
        </div>

        <div class="flex justify-center">
            {{ $footer }}
        </div>

    </div>
</div>
