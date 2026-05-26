<div x-show="currentTab === 'third'">
    <div
        class="grid grid-cols-1 xl:grid-cols-[1fr_400px] gap-6"
        x-data="{ selectedPlayer: null }"
    >
        <div class="rounded-3xl p-6">
            <div class="flex justify-center mb-6">
                <select
                    wire:model.live="match_composition"
                    class="w-fit min-w-[220px] rounded-2xl px-4 py-3 text-center text-white outline-none transition hover:border-purple-500 focus:border-purple-500">
                    @foreach(config('player_compositions') as $formationName => $composition)
                        <option value="{{ $formationName }}" class="bg-[#25284B] text-white">
                            {{ $formationName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="relative w-full h-[700px] rounded-3xl overflow-hidden">
                <span class="text-white">
                    @foreach(config('player_compositions.' . $this->match_composition) as $player)
                        @php
                            $displayName = $player['poste'];

                            if (isset($this->player_position[$player['poste']])) {
                                $playerId = $this->player_position[$player['poste']];

                                $selectedPlayerData = $this->games->players->firstWhere('id', $playerId);

                                if ($selectedPlayerData) {
                                    $displayName = $selectedPlayerData->firstName;
                                }
                            }
                        @endphp

                        <div
                            @click="selectedPlayer = '{{ $player['poste'] }}'"
                            class="cursor-pointer"
                        >
                            <x-player_position
                                x="{{ $player['x'] }}"
                                y="{{ $player['y'] }}"
                                poste="{{ $displayName }}"
                            />
                        </div>
                    @endforeach
                </span>
            </div>
        </div>

        <div class="hidden xl:flex rounded-3xl border border-purple-500/20 bg-[#1A1C38] p-5 h-[820px] flex-col">
            <div class="mb-4">
                <h2 class="text-white text-2xl font-bold">Joueurs</h2>

                <p
                    class="text-sm text-purple-400 mt-1"
                    x-show="selectedPlayer"
                    x-text="'Poste sélectionné : ' + selectedPlayer"
                ></p>
            </div>

            <div class="mb-4">
                <input
                    wire:model.live.debounce.300ms="searchPlayer"
                    placeholder="Rechercher un joueur..."
                    class="w-full rounded-2xl border border-purple-500/20 bg-[#25284B] px-4 py-3 text-white placeholder:text-gray-400 outline-none"
                >
            </div>

            <div class="flex-1 overflow-y-auto space-y-6 pr-2">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-purple-400 mb-3">
                        Joueurs aux poste
                    </h3>

                    <div class="space-y-3">
                        @foreach($this->games->players as $player)
                            <div
                                x-show="selectedPlayer === '{{ $player->position }}'"
                                x-cloak>
                                @if($player->pivot->status === "present")
                                    <div
                                        @click="$wire.assignPlayerToPosition(selectedPlayer,{{ $player->pivot->player_id }})"
                                        class="flex items-center justify-between rounded-2xl border border-purple-500/20 bg-[#25284B] p-4 cursor-pointer transition hover:bg-[#2D315D]">
                                        <div>
                                            <p class="text-white font-semibold">
                                                {{ $player->firstName }}
                                            </p>

                                            <p class="text-xs text-gray-400 uppercase">
                                                {{ $player->position }}
                                            </p>
                                        </div>

                                        <div class="h-4 w-4 rounded-full bg-green-400"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-3">
                        Autres joueurs
                    </h3>

                    <div class="space-y-3">
                        @foreach($this->games->players as $player)
                            <div
                                x-show="selectedPlayer !== '{{ $player->position }}'"
                                x-cloak
                            >
                                @if($player->pivot->status === "present")
                                    <div
                                        @click="$wire.assignPlayerToPosition(selectedPlayer,{{ $player->pivot->player_id }})"
                                        class="flex items-center justify-between rounded-2xl border border-purple-500/10 bg-[#222547] p-4 cursor-pointer transition hover:bg-[#2A2E57]"
                                    >
                                        <div>
                                            <p class="text-white font-semibold">
                                                {{ $player->firstName }}
                                            </p>

                                            <p class="text-xs text-gray-400 uppercase">
                                                {{ $player->position }}
                                            </p>
                                        </div>

                                        <div class="h-4 w-4 rounded-full border border-gray-400"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div
            x-show="selectedPlayer"
            x-transition
            class="fixed inset-0 z-50 flex xl:hidden items-center justify-center bg-black/50 p-4"
            style="display:none;"
        >
            <div
                @click.away="selectedPlayer = null"
                class="relative w-full max-w-md rounded-3xl border border-purple-500/30 bg-[#1F2243] shadow-2xl overflow-hidden"
            >
                <div class="flex items-center justify-between p-6 pb-4">
                    <div>
                        <h2 class="text-white text-2xl font-bold">Choisir un joueur</h2>

                        <p class="text-sm text-gray-400 mt-1">
                            Poste :
                            <span class="text-purple-400 font-semibold" x-text="selectedPlayer"></span>
                        </p>
                    </div>

                    <button
                        @click="selectedPlayer = null"
                        class="text-white text-xl hover:opacity-70"
                    >
                        ✕
                    </button>
                </div>

                <div class="px-6 pb-4">
                    <input
                        wire:model.live.debounce.300ms="searchPlayer"
                        placeholder="Rechercher un joueur..."
                        class="w-full rounded-2xl border border-purple-500/20 bg-[#2A2D55] px-4 py-3 text-white placeholder:text-gray-400 outline-none"
                    >
                </div>

                <div class="px-6 pb-6 overflow-y-auto max-h-[500px] space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-purple-400 mb-3">
                            Joueurs aux poste
                        </h3>

                        <div class="space-y-3">
                            @foreach($this->games->players as $player)
                                <div
                                    x-show="selectedPlayer === '{{ $player->position }}'"
                                    x-cloak>
                                    @if($player->pivot->status === "present")
                                        <label
                                            class="flex items-center justify-between rounded-2xl border border-purple-500/20 bg-[#25284B] p-4 cursor-pointer hover:bg-[#2D315D] transition">
                                            <div>
                                                <img src="{{asset('f2918708-1aed-4d65-9c03-a2f99ca01212 5.png')}}" alt="">
                                                <p class="text-white font-semibold">{{ $player->firstName }}</p>
                                                <p class="text-xs text-gray-400 uppercase">{{ $player->position }}</p>
                                            </div>

                                            <input
                                                type="checkbox"
                                                class="h-5 w-5 accent-purple-500"
                                                @click="$wire.assignPlayerToPosition(selectedPlayer,{{ $player->pivot->player_id }})"
                                            >
                                        </label>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-3">
                            Autres joueurs
                        </h3>

                        <div class="space-y-3">
                            @foreach($this->games->players as $player)
                                <div
                                    x-show="selectedPlayer !== '{{ $player->position }}'"
                                    x-cloak>
                                    @if($player->pivot->status === "present")
                                        <label
                                            class="flex items-center justify-between rounded-2xl border border-purple-500/10 bg-[#222547] p-4 cursor-pointer hover:bg-[#2A2E57] transition">
                                            <div>
                                                <img src="{{asset('f2918708-1aed-4d65-9c03-a2f99ca01212 5.png')}}" alt="">
                                                <p class="text-white font-semibold">{{ $player->firstName }}</p>
                                                <p class="text-xs text-gray-400 uppercase">{{ $player->position }}</p>
                                            </div>

                                            <input
                                                type="checkbox"
                                                class="h-5 w-5 accent-purple-500"
                                                @click="$wire.assignPlayerToPosition(selectedPlayer,{{ $player->pivot->player_id }})"
                                            >
                                        </label>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 flex justify-center">
                    <button
                        @click="selectedPlayer = null"
                        class="btn-primary"
                    >
                        Valider
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
