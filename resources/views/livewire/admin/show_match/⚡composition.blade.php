<?php

use App\Actions\Match\SaveComposition;
use App\Models\Game;
use App\Models\MatchComposition;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component {

    public Game $match;

    public string $match_composition = "4-4-2";

    public array $player_position = [];

    public string $searchPlayer = '';

    public function mount(Game $match): void
    {
        $this->match = $match;

        MatchComposition::where('match_id', $this->match->id)
            ->get()
            ->each(function ($composition) {
                $this->player_position[$composition->position] = $composition->player_id;
            });
    }

    public function getPlayerAttendanceProperty(): array
    {
        $totalTrains = Auth::user()->currentTeam()?->trains()->count() ?? 0;

        return $this->match->players->mapWithKeys(function ($player) use ($totalTrains) {
            $presences = $player->trains()->wherePivot('status', 'present')->count();

            $rate = $totalTrains > 0 ? (int) round($presences / $totalTrains * 100) : 0;

            return [$player->id => $rate];
        })->all();
    }

    public function getPlayersAtPostProperty(): Collection
    {
        $players = $this->match->players->filter(fn ($player) => $player->pivot->status === 'present');

        if ($this->searchPlayer !== '') {
            $players = $players->filter(
                fn ($player) => str_contains(strtolower($player->firstName), strtolower($this->searchPlayer))
            );
        }

        return $players;
    }

    public function getAvailablePlayersProperty(): Collection
    {
        $assignedIds = array_values($this->player_position);

        return $this->playersAtPost->reject(fn ($player) => in_array($player->id, $assignedIds));
    }

    public function getPlacedPlayersProperty(): Collection
    {
        $assignedIds = array_values($this->player_position);

        return $this->playersAtPost->filter(fn ($player) => in_array($player->id, $assignedIds));
    }

    public function assignPlayerToPosition($poste, $idPlayer): void
    {
        $alreadyAssigned = collect($this->player_position)->contains($idPlayer);

        if ($alreadyAssigned && ($this->player_position[$poste] ?? null) !== $idPlayer) {
            return;
        }

        $this->player_position[$poste] = $idPlayer;
    }

    public function saveComposition(): void
    {
        (new SaveComposition())->handle($this->match, $this->player_position);

        $this->dispatch('notify', message: 'Composition enregistrée avec succès.', type: 'success');
    }

};
?>

<div x-data="{ selectedPlayer: null }">

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_400px] gap-6">
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
                            $displayImage = null;

                            if (isset($this->player_position[$player['poste']])) {
                                $playerId = $this->player_position[$player['poste']];

                                $selectedPlayerData = $this->match->players->firstWhere('id', $playerId);

                               if ($selectedPlayerData) {
                                   $displayName = $selectedPlayerData->firstName;
                                   $displayImage = $selectedPlayerData->user->image_url;
                               }
                            }
                        @endphp

                        <div
                            @click="selectedPlayer = '{{ $player['poste'] }}'"
                            :class="selectedPlayer === '{{ $player['poste'] }}'
        ? '[&_img]:border-purple-500'
        : '[&_img]:border-white'"
                            class="cursor-pointer"
                        >
    <x-player_position
        x="{{ $player['x'] }}"
        y="{{ $player['y'] }}"
        poste="{{ $displayName }}"
        activePoste="{{ $player['poste'] }}"
        :image="$displayImage"
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

            @if($this->playersAtPost->isEmpty())

                <div class="flex-1 flex items-center justify-center text-center px-4">
                    <p class="text-sm text-gray-400">
                        Aucun joueur n'a encore confirmé sa présence pour ce match.<br>
                        La composition sera disponible dès qu'un joueur aura répondu "présent" à sa convocation.
                    </p>
                </div>

            @else

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
                        @foreach($this->availablePlayers as $player)
                            <x-admin.show-match.player-slot
                                :player="$player"
                                :attendance-rate="$this->playerAttendance[$player->id] ?? 0"
                                :when-selected="true"
                            />
                        @endforeach

                        @foreach($this->placedPlayers as $player)
                            <x-admin.show-match.player-slot
                                :player="$player"
                                :when-selected="true"
                                :placed="true"
                            />
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-3">
                        Autres joueurs
                    </h3>
                    <div class="space-y-3">
                        @foreach($this->availablePlayers as $player)
                            <x-admin.show-match.player-slot
                                :player="$player"
                                :attendance-rate="$this->playerAttendance[$player->id] ?? 0"
                                :when-selected="false"
                            />
                        @endforeach

                        @foreach($this->placedPlayers as $player)
                            <x-admin.show-match.player-slot
                                :player="$player"
                                :when-selected="false"
                                :placed="true"
                            />
                        @endforeach
                    </div>
                </div>
            </div>

            @endif
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
                            Poste : <span class="text-purple-400 font-semibold" x-text="selectedPlayer"></span>
                        </p>
                    </div>
                    <button @click="selectedPlayer = null" class="text-white text-xl hover:opacity-70 cursor-pointer">✕</button>
                </div>

                @if($this->playersAtPost->isEmpty())

                    <div class="px-6 pb-6">
                        <p class="text-sm text-gray-400 text-center">
                            Aucun joueur n'a encore confirmé sa présence pour ce match.<br>
                            La composition sera disponible dès qu'un joueur aura répondu "présent" à sa convocation.
                        </p>
                    </div>

                @else

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
                            @foreach($this->availablePlayers as $player)
                                <x-admin.show-match.player-slot-mobile
                                    :player="$player"
                                    :attendance-rate="$this->playerAttendance[$player->id] ?? 0"
                                    :when-selected="true"
                                />
                            @endforeach

                            @foreach($this->placedPlayers as $player)
                                <x-admin.show-match.player-slot-mobile
                                    :player="$player"
                                    :when-selected="true"
                                    :placed="true"
                                />
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-3">
                            Autres joueurs
                        </h3>
                        <div class="space-y-3">
                            @foreach($this->availablePlayers as $player)
                                <x-admin.show-match.player-slot-mobile
                                    :player="$player"
                                    :attendance-rate="$this->playerAttendance[$player->id] ?? 0"
                                    :when-selected="false"
                                />
                            @endforeach

                            @foreach($this->placedPlayers as $player)
                                <x-admin.show-match.player-slot-mobile
                                    :player="$player"
                                    :when-selected="false"
                                    :placed="true"
                                />
                            @endforeach
                        </div>
                    </div>
                </div>

                @endif

                <div class="p-6 pt-0 flex justify-center">
                    <button @click="selectedPlayer = null" class="btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>

    <button
        wire:click="saveComposition"
        class="btn-primary">
        Enregistrer la composition
    </button>

</div>
