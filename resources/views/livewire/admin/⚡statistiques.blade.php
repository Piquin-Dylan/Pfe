<?php

use App\Models\Train;
use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $players;
    public string $search = '';
    public int $totalTrains = 0;

    public function mount()
    {
        $this->players = Auth::user()->team->players()->get();

        $totalTrains = Auth::user()->team->trains()->count();

        $this->players->each(function ($player) use ($totalTrains) {

            $presences = $player->trains()
                ->wherePivot('status', 'present')
                ->count();

            $player->attendance_percentage = $totalTrains > 0
                ? round(($presences / $totalTrains) * 100)
                : 0;
            $player->presences = $presences;
        });
    }

    public function getFilteredPlayersProperty()
    {
        return $this->players->filter(function ($player) {
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
        <h1 class="text-2xl font-bold text-white">
            Statistiques des joueurs
        </h1>

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
    />
</div>
