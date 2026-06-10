<?php

use Livewire\Component;

new class extends Component {
    public string $search = '';
    public int $totalTrains = 0;
    public int $totalMatchs = 0;

    public function mount(): void
    {
        $this->totalTrains = Auth::user()->team->trains()->count();
        $this->totalMatchs = Auth::user()->team->games()->count();
    }

    public function getFilteredPlayersProperty()
    {
        $players = Auth::user()->team->players()->get();

        $players->each(function ($player) {

            $presences = $player->trains()
                ->wherePivot('status', 'present')
                ->count();

            $matchsJoues = $player->games()
                ->wherePivot('status', 'present')
                ->count();

            $player->attendance_percentage = $this->totalTrains > 0
                ? round(($presences / $this->totalTrains) * 100)
                : 0;

            $player->matches_percentage = $this->totalMatchs > 0
                ? round(($matchsJoues / $this->totalMatchs) * 100)
                : 0;

            $player->presences = $presences;
            $player->matchs_joues = $matchsJoues;
        });

        return $players->filter(function ($player) {
            return str_contains(
                strtolower($player->firstName),
                strtolower($this->search)
            );
        });
    }
};
?>

<div class="space-y-4">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">
            Statistiques des joueurs
        </h2>

        <p class="text-gray-400 mt-1">
            Consultez les statistiques de l'ensemble des joueurs de votre équipe.
        </p>
    </div>
    <div class="mb-4">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Rechercher un joueur..."
            class="w-full rounded-2xl border border-purple-500/20 bg-white px-4 py-3 text-black placeholder:text-gray-400 outline-none focus:border-purple-500"
        >
    </div>
    <x-admin.statistiques.player-stats-card
        :players="$this->filteredPlayers"
        :total-trains="$totalTrains"
        :total-matchs="$totalMatchs"
    />
</div>
