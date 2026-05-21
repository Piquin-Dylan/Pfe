<div x-data="{ openModal: false }">

    <div x-show="currentTab === 'second'" class="flex flex-wrap justify-center gap-8">

        <div class="w-full flex flex-col items-center pb-10 gap-6">

            <div class="bg-[#23294A] border border-violet-500/30 rounded-2xl px-8 py-4 shadow-lg">
                <div class="text-center">
                    <p class="text-violet-300 text-lg font-medium uppercase tracking-wider">
                        Nombre de joueurs présents
                    </p>

                    <span class="text-white text-5xl font-bold">
                            {{ $this->count_player }}
                        </span>
                </div>
            </div>

            <button
                @click="openModal = true"
                class="btn-primary">
                Reconvoquer les joueurs
            </button>

        </div>

        @php
            $playerId = $this->games->players->pluck('id');

            $playersNotConvoked = \App\Models\Player::whereNotIn('players.id', $playerId)
                ->where('team_id', $this->games->players->first()?->team_id)
                ->get();
        @endphp

        @foreach($this->games->players as $player)

            <div class="relative">
                    <span class="text-white absolute font-bold text-xl left-8 top-8 z-10">
                        {{ $player->name }}
                    </span>

                <img
                    class="w-[250px] pb-4"
                    src="{{ asset('Component_card_player.svg') }}"
                    alt=""
                >

                <div class="flex justify-center">
                        <span
                            @class([
                                'px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wide border',
                                'bg-green-500/20 text-green-400 border-green-500/40' => $player->pivot->status === 'present',
                                'bg-red-500/20 text-red-400 border-red-500/40' => $player->pivot->status === 'absent',
                                'bg-orange-500/20 text-orange-400 border-orange-500/40' => $player->pivot->status === 'en attente',
                            ])
                        >
                            {{ $player->pivot->status }}
                        </span>
                </div>
            </div>

        @endforeach

        <div
            x-show="openModal"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
            style="display: none;"
        >

            <div
                @click.away="openModal = false"
                class="bg-[#23294A] border border-violet-500/30 rounded-3xl p-8 w-full max-w-2xl shadow-2xl"
            >

                <div class="flex justify-between items-center pb-8">
                    <h2 class="text-white text-3xl font-bold">
                        Reconvoquer des joueurs
                    </h2>

                    <button
                        @click="openModal = false"
                        class="text-white text-2xl hover:text-violet-400 transition">
                        ✕
                    </button>
                </div>

                <div class="flex flex-col gap-4">

                    @foreach($playersNotConvoked as $player)

                        <label
                            class="flex items-center justify-between bg-[#1B2340]
                                border border-violet-500/20 rounded-2xl px-6 py-4
                                hover:border-violet-500/50 transition cursor-pointer"
                        >

                            <div class="flex flex-col">
                                    <span class="text-white text-lg font-semibold">
                                        {{ $player->firstName }}
                                    </span>

                                <span class="text-violet-300 text-sm uppercase tracking-wider">
                                        {{ $player->position }}
                                    </span>
                            </div>

                            <input
                                type="checkbox"
                                class="h-6 w-6 accent-violet-500"
                            >

                        </label>

                    @endforeach
                    <div class="pt-8 flex justify-end">
                        <button
                            wire:click="saveSecondConvocation"
                            class="btn-primary">
                            Valider la reconvocation
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
