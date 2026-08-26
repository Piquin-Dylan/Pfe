<?php

use App\Models\Game;
use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;

    public int $score_home;
    public int $score_away;

    public bool $showTutorial = true;

    public string $searchMatch = '';

    public string $matchFilter = 'tous';

    public function mount(): void
    {
        //code sur le tuto
        if (Auth::user()->tutorial()->where('tutorial_name', 'match_list')->exists()) {
            $this->showTutorial = false;
        } else {
            $this->showTutorial = true;
            \App\Models\Tutorial::create([
                'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
                'tutorial_name' => "match_list",
                'seen' => true
            ]);
            $this->dispatch('start-match-list-tutorial');
        }
    }

    public function updatedSearchMatch(): void
    {
        $this->resetPage();
    }

    public function filterMatch(string $value): void
    {
        $this->matchFilter = $value;
        $this->resetPage();
    }

    public function getGamesProperty(): LengthAwarePaginator
    {
        $teamId = Auth::user()->currentTeam()?->id;

        return Game::where('team_id', $teamId)
            ->when($this->searchMatch, function ($query) {
                $query->where(function ($q) {
                    $q->where('name_away', 'like', '%' . $this->searchMatch . '%')
                        ->orWhere('address', 'like', '%' . $this->searchMatch . '%');
                });
            })
            ->when($this->matchFilter === 'a_venir', fn ($query) => $query->where(fn ($q) => $q->whereNull('score_home')->orWhereNull('score_away')))
            ->when($this->matchFilter === 'joues', fn ($query) => $query->whereNotNull('score_home')->whereNotNull('score_away'))
            ->orderBy('date_match', 'asc')
            ->paginate(6);
    }

    public function updateScore($id)
    {
        $game = Game::findOrFail($id);

        $this->authorize('update', $game);

        $game->update([
            'score_home' => $this->score_home,
            'score_away' => $this->score_away
        ]);
        $this->dispatch('score-updated');
        $this->dispatch('notify', message: 'Score mis à jour avec succès.', type: 'success');
    }
};
?>

<div class="max-w-7xl mx-auto">
    <div class="w-full flex justify-center max-w-[250px] mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('admin.create_event')
    </div>

    <div class="px-4 sm:px-6 lg:px-8 pt-6">
        <input
            class="bg-white p-4 text-black rounded-2xl w-full"
            wire:model.live.debounce="searchMatch"
            placeholder="Rechercher un match (adversaire, lieu)"
        >
    </div>

    <div class="flex flex-wrap justify-center gap-3 sm:gap-4 md:gap-5 lg:gap-8 pt-6 pb-2">
        <span
            class="filter_position text-sm md:text-base {{ $matchFilter === 'tous' ? 'active' : '' }}"
            wire:click="filterMatch('tous')">
            Tous
        </span>

        <span
            class="filter_position text-sm md:text-base {{ $matchFilter === 'a_venir' ? 'active' : '' }}"
            wire:click="filterMatch('a_venir')">
            À venir
        </span>

        <span
            class="filter_position text-sm md:text-base {{ $matchFilter === 'joues' ? 'active' : '' }}"
            wire:click="filterMatch('joues')">
            Joués
        </span>
    </div>

    @if($this->games->isEmpty() && ($searchMatch !== '' || $matchFilter !== 'tous'))
        <div class="max-w-2xl mx-4 sm:mx-auto mt-6 sm:mt-10 p-4 sm:p-8 rounded-2xl sm:rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-lg sm:text-2xl font-bold text-white mb-3 sm:mb-4">
                Aucun match ne correspond à votre recherche
            </h3>

            <p class="text-sm sm:text-base text-gray-300">
                Essayez un autre nom ou réinitialisez les filtres.
            </p>
        </div>
    @elseif($this->games->isEmpty())
        <x-match.empy-match
            title="Aucun match n'a encore été créé pour le moment"
            description="Créez dès maintenant votre premier match dans la page calendrier"
            :href="route('calendrier')"
            button="Créer mon premier match"
        />
    @else
        @foreach($this->games as $game)

            <h2 id="address" class="title_section px-4 pt-6 lg:pt-10 text-center break-words lg:text-left">
                Match du {{ \Carbon\Carbon::parse($game->date_match)->locale('fr')->translatedFormat('d F Y') }}
                : {{ $game->address }}
            </h2>

            <article id="affiche" class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-4 md:gap-8 pt-4 pb-8">

                <h3 class="sr-only">Détail du match</h3>
                <div class="flex flex-col items-center text-center min-w-0">
                    <div
                        class="flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 mb-3 sm:mb-6">
                        @php
                            $team = Auth::user()->currentTeam();
                        @endphp

                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe domicile"
                            src="{{ $team->logo_url }}"
                            srcset="  {{ $team->logo_url }} 128w,  {{ $team->logo_url }} 256w,  {{ $team->logo_url }} 512w"
                            sizes=" (max-width: 640px) 64px, (max-width: 768px) 80px, (max-width: 1024px) 128px, 160px"
                            loading="lazy" decoding="async">
                    </div>

                    <span
                        class="text-white text-sm sm:text-base md:text-xl max-w-[100px] sm:max-w-[140px] md:max-w-[220px] break-words leading-tight">
            {{  $team->name }}
        </span>
                </div>

                <div class="flex items-center justify-center h-full">
        <span class="text-lg sm:text-xl md:text-3xl text-white font-semibold whitespace-nowrap">
            @if($game->score_home !== null && $game->score_away !== null)
                <span>{{ $game->score_home }} - {{ $game->score_away }}</span>
            @else
                {{ $game->hours }}
            @endif
        </span>
                </div>

                <div class="flex flex-col items-center text-center min-w-0">
                    <div
                        class="flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 mb-3 sm:mb-6">
                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe extérieur"
                            src="{{ $game->photo_away_url }}"
                            srcset="  {{ $game->photo_away_url }} 128w,  {{ $game->photo_away_url }} 256w,  {{ $game->photo_away_url }} 512w "
                            sizes=" (max-width: 640px) 64px, (max-width: 768px) 80px, (max-width: 1024px) 128px, 160px "
                            loading="lazy"
                            decoding="async"/>
                    </div>
                    <span
                        class="text-white text-sm sm:text-base md:text-xl max-w-[100px] sm:max-w-[140px] md:max-w-[220px] break-words leading-tight">
                {{ $game->name_away }}</span>
                </div>

            </article>

            @cannot('manage-team')
                <div class="flex justify-center pb-8">
                    <a href="/match/{{ $game->uuid }}" class="btn-primary">
                        Voir les détails
                    </a>
                </div>
            @endcannot

            <div x-data="{openScoreModal: false}"

                 x-on:score-updated.window="openScoreModal = false">
                @can('manage-team')
                    <x-match.score
                        :game-id="$game->id"/>
                @endcan

                <x-match.modal-score
                    show="openScoreModal"
                    close="openScoreModal = false"
                    :home-logo="$team->logo_url"
                    :home-name="$team->name"
                    :away-logo="$game->photo_away_url"
                    :away-name="$game->name_away">
                    <input wire:model="score_home" type="number" min="0"
                           class=" text-black h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-transparent bg-white text-center text-2xl sm:text-3xl font-black outline-none transition focus:border-violet-500">
                    <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-white">-</span>

                    <input
                        wire:model="score_away"
                        type="number"
                        min="0"
                        class="text-black h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-transparent bg-white text-center text-2xl sm:text-3xl font-black outline-none transition focus:border-violet-500">

                    <x-slot:footer>
                        <button wire:click="updateScore({{ $game->id }})" class="btn-form">
                            Confirmer
                        </button>
                    </x-slot:footer>
                </x-match.modal-score>
            </div>
        @endforeach

        <div class="px-4 sm:px-6 lg:px-8 pb-10">
            {{ $this->games->links() }}
        </div>
    @endif
</div>
