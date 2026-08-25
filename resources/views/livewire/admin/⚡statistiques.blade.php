<?php

use Livewire\Component;

new class extends Component {
    public string $search = '';
    public int $totalTrains = 0;
    public int $totalMatchs = 0;

    public int $wins = 0;
    public int $draws = 0;
    public int $losses = 0;
    public int $goalsFor = 0;
    public int $goalsAgainst = 0;
    public int $winRate = 0;
    public array $recentForm = [];

    public function mount(): void
    {
        $this->totalTrains = Auth::user()->team->trains()->count();
        $this->totalMatchs = Auth::user()->team->games()->count();

        $this->computeClubStats();
    }

    public function computeClubStats(): void
    {
        $finishedGames = Auth::user()->team->games()
            ->whereNotNull('score_home')
            ->whereNotNull('score_away')
            ->orderByDesc('date_match')
            ->get();

        foreach ($finishedGames as $game) {
            if ($game->score_home > $game->score_away) {
                $this->wins++;
            } elseif ($game->score_home < $game->score_away) {
                $this->losses++;
            } else {
                $this->draws++;
            }

            $this->goalsFor += $game->score_home;
            $this->goalsAgainst += $game->score_away;
        }

        $played = $finishedGames->count();
        $this->winRate = $played > 0 ? (int) round($this->wins / $played * 100) : 0;

        $this->recentForm = $finishedGames->take(5)->map(function ($game) {
            return match (true) {
                $game->score_home > $game->score_away => 'V',
                $game->score_home < $game->score_away => 'D',
                default => 'N',
            };
        })->all();
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
    <x-admin.statistiques.club-stats-card
        :wins="$wins"
        :draws="$draws"
        :losses="$losses"
        :goals-for="$goalsFor"
        :goals-against="$goalsAgainst"
        :win-rate="$winRate"
        :recent-form="$recentForm"
    />

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
