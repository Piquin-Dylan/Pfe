<div x-show="currentTab === 'third'">

    <select wire:model.live="match_composition" class="bg-white">
        @foreach(config('player_compositions') as $formationName=> $composition)

            <option value="{{$formationName}}">{{$formationName}}</option>
        @endforeach

    </select>

    <div
        class="relative w-full h-[600px] rounded-xl overflow-hidden bg-cover bg-center"
        x-data="{ selectedPlayer: null }"
        {{-- style="background-image: url('{{ asset('football-field-soccer-field-background-green-lawn-court-create-game_64749-2031.avif') }}');" --}}
    >
            <span class="text-white">
            @foreach(config('player_compositions.' . $this->match_composition) as $player)
                    @php
                        $displayName = $player['poste'];

                        if (isset($this->player_position[$player['poste']])) {
                            $playerId = $this->player_position[$player['poste']];

                            $selectedPlayer = $this->games->players->firstWhere('id', $playerId);

                            if ($selectedPlayer) {
                                $displayName = $selectedPlayer->firstName;
                            }
                        }
                    @endphp

                    <div
                        @click="selectedPlayer = {
            poste: '{{ $player['poste'] }}',
            x: '{{ $player['x'] }}',
            y: '{{ $player['y'] }}'
            }"
                        class="cursor-pointer"
                    >
            <x-player_position
                x="{{ $player['x'] }}"
                y="{{ $player['y'] }}"
                poste="{{ $displayName }}">

            </x-player_position>
            </div>
                @endforeach
            </span>

        <div
            x-show="selectedPlayer"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            style="display: none;">
            <div
                class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md relative"
                @click.away="selectedPlayer = null">
                <button
                    @click="selectedPlayer = null"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕
                </button>

                <div class="text-gray-700">
                    <strong>Ajouter un joueur au poste de :</strong>
                    <span x-text="selectedPlayer?.poste"></span>

                    <ul class="mt-2 space-y-1">
                        <input class="bg-white p-4 rounded-2xl w-full" wire:model.live.debounce="searchPlayer"
                               placeholder="rechercher un joueur">
                        @foreach($this->games->players as $player)
                            <li
                                x-show="selectedPlayer?.poste === '{{ $player->position}}'"
                                x-cloak>
                                @if($player->pivot->status === "present")
                                    <input
                                        @click="$wire.assignPlayerToPosition(selectedPlayer?.poste,{{$player->pivot->player_id}})"
                                        type="checkbox">{{$player->firstName}}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
