<div x-show="currentTab === 'first'">
    <div class="text-white text-center pb-6">
        Nombre de joueurs convoqués :
        {{ count($checked) }} / {{ $newValue }}
    </div>

    <div class="flex justify-center pb-8">
        <button
            wire:click="saveConvocation"
            class="btn-form">
            Enregistrer les convocations
        </button>
    </div>

    <div class="flex justify-center gap-16 flex-wrap">
        @foreach($this->players as $player)
            <label class="cursor-pointer group flex flex-col items-center">
                <div
                    class="relative transition-all duration-300 ease-in-out
                       group-hover:scale-105 group-hover:-translate-y-2
                       group-hover:drop-shadow-[0_0_25px_rgba(255,255,255,0.25)]"
                >
                <span class="text-white absolute font-bold text-xl left-8 top-8 z-10">
                    {{ $player->firstName }}
                </span>

                    <div
                        class="absolute inset-0 rounded-2xl border-4 border-transparent
                           peer-checked:border-indigo-500
                           transition-all duration-300"
                    ></div>

                    <img
                        class="w-[250px] pb-6 transition-all duration-300
                           group-hover:brightness-110"
                        src="{{ asset('Component_card_player.svg') }}"
                        alt="">
                </div>

                <input
                    wire:model.live="checked"
                    type="checkbox"
                    value="{{ $player->id }}"
                    class="mt-4 h-6 w-6 accent-indigo-500">
            </label>
        @endforeach
    </div>
</div>
