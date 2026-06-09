<noscript>
    <div class="max-w-7xl mx-auto space-y-6">

        <h3 class="text-3xl font-bold text-white text-center mb-8">
            Exemple de composition 4-3-3
        </h3>

        <div class="flex flex-col xl:flex-row gap-6">

            {{-- Terrain --}}
            <div
                class="relative w-full h-[500px] xl:h-[700px] rounded-3xl overflow-hidden border border-purple-500/20"
                style="
                    background-image: url('{{ asset('terrain.jpg') }}');
                    background-size: cover;
                    background-position: center;
                "
            >
                <div class="absolute left-[18%] top-[22%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Lucas</p>
                    <p class="text-xs text-gray-400">AG</p>
                </div>

                <div class="absolute left-[50%] top-[16%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Yanis</p>
                    <p class="text-xs text-gray-400">BU</p>
                </div>

                <div class="absolute left-[82%] top-[22%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Sacha</p>
                    <p class="text-xs text-gray-400">AD</p>
                </div>

                <div class="absolute left-[25%] top-[52%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Jules</p>
                    <p class="text-xs text-gray-400">MC</p>
                </div>

                <div class="absolute left-[50%] top-[58%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Liam</p>
                    <p class="text-xs text-gray-400">MDC</p>
                </div>

                <div class="absolute left-[75%] top-[52%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Adam</p>
                    <p class="text-xs text-gray-400">MOC</p>
                </div>

                <div class="absolute left-[15%] top-[72%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Noah</p>
                    <p class="text-xs text-gray-400">DG</p>
                </div>

                <div class="absolute left-[38%] top-[74%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Mathis</p>
                    <p class="text-xs text-gray-400">DC</p>
                </div>

                <div class="absolute left-[62%] top-[74%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Enzo</p>
                    <p class="text-xs text-gray-400">DC</p>
                </div>

                <div class="absolute left-[85%] top-[72%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Theo</p>
                    <p class="text-xs text-gray-400">DD</p>
                </div>

                <div class="absolute left-[50%] top-[90%] -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="w-12 h-12 xl:w-16 xl:h-16 rounded-full bg-[#1F2243] mx-auto"></div>
                    <p class="text-white font-semibold mt-1 text-sm xl:text-base">Hugo</p>
                    <p class="text-xs text-gray-400">GB</p>
                </div>
            </div>

            {{-- Joueurs --}}
            <div class="xl:w-[400px] xl:shrink-0 rounded-3xl border border-purple-500/20 bg-[#1A1C38] p-6 xl:overflow-y-auto xl:max-h-[700px]">

                <h4 class="text-white text-2xl font-bold mb-6">
                    Joueurs disponibles
                </h4>

                <div class="space-y-3">
                    @foreach([
                        ['Lucas', 'AG'], ['Nathan', 'AG'],
                        ['Mathis', 'DC'], ['Enzo', 'DC'],
                        ['Theo', 'DD'], ['Noah', 'DG'],
                        ['Liam', 'MDC'], ['Ethan', 'MDC'],
                        ['Jules', 'MC'], ['Tom', 'MC'],
                        ['Adam', 'MOC'], ['Sacha', 'AD'],
                        ['Aaron', 'AD'], ['Yanis', 'BU'],
                        ['Leo', 'BU'], ['Hugo', 'GB'],
                    ] as [$name, $pos])
                        <div class="flex items-center justify-between rounded-2xl border border-purple-500/20 bg-[#25284B] p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-purple-500/30">
                                    <img src="{{ asset('person.png') }}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div>
                                    <p class="text-white font-semibold">{{ $name }}</p>
                                    <p class="text-xs text-gray-400 uppercase">{{ $pos }}</p>
                                </div>
                            </div>
                            <div class="h-4 w-4 rounded-full bg-green-400"></div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>

    </div>
</noscript>
