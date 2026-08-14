<?php

use App\Models\Player;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

new class extends Component {

    public string $searchPlayer = "";

    public string $filters = 'tout';

    public array $poste = [
        'attaquant' => ['BU', 'AG', 'AD'],
        'milieux' => ['MCD', 'MC', 'MCG'],
        'defenseur' => ['DG', 'DC', 'DD'],
        'gardien' => ['G'],
    ];

    public ?Collection $playersWithStatus = null;

    public array $playerStatuses = [];

    public bool $isMatch = false;

    public int $count = 0;

    public array $checked = [];

    public function mount(?Collection $playersWithStatus = null): void
    {
        $this->playersWithStatus = $playersWithStatus;

        if ($playersWithStatus) {
            $this->playerStatuses = $playersWithStatus
                ->mapWithKeys(fn ($player) => [$player->id => $player->pivot->status])
                ->all();
        }
    }

    public function filter($string): void
    {
        $this->filters = $string;
    }

    //Fonction qui permet de pouvoir afficher les joueurs appartenant a un club de l"utilisateur connecter qui est donc le coach du club
    public function getPlayersProperty(): Collection
    {
        $user = Auth::user();

        return Player::where(function ($query) use ($user) {

            $query->whereHas('team', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });

            if ($user->player) {
                $query->orWhere('team_id', $user->player->team_id);
            }
        })
            ->when($this->searchPlayer, function ($query) {
                $query->where(
                    'firstName',
                    'like',
                    '%' . $this->searchPlayer . '%'
                );
            })
            ->when($this->filters !== 'tout', function ($query) {
                $query->where(
                    'players.position',
                    $this->poste[$this->filters]
                );
            })
            ->with([
                'user',
                'team:id,user_id',
                'trains'
            ])
            ->get();
    }
};
?>

<div class="max-w-7xl mx-auto grow">

    <h2 class="title_section p-5">Mon équipe</h2>

    <div class="pr-5 pl-5">
        <input
            class="bg-white p-4 text-black rounded-2xl w-full"
            wire:model.live.debounce="searchPlayer"
            placeholder="Rechercher un joueur"
        >
    </div>

    <x-admin.filter_position/>

    @php
        $players = $playersWithStatus ?? $this->players;
    @endphp

    @if($players->isEmpty())
        <div
            class="max-w-2xl mx-4 sm:mx-auto mt-6 sm:mt-10 p-4 sm:p-8 rounded-2xl sm:rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-lg sm:text-2xl font-bold text-white mb-3 sm:mb-4">
                Aucun joueur dans votre équipe
            </h3>

            <p class="text-sm sm:text-base text-gray-300 mb-4 sm:mb-6">
                Partagez ce code avec vos joueurs pour qu'ils puissent rejoindre votre équipe.
            </p>

            <div class="inline-flex items-center bg-white/10 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl">
        <span class="text-xl sm:text-3xl font-bold tracking-wide sm:tracking-widest text-white break-all">
            {{ Auth::user()->team?->code ?? Auth::user()->player?->team?->code }}
        </span>
            </div>
        </div>
    @else
        <div class="flex justify-center gap-12 flex-wrap">

            @foreach($players as $player)
                <div class="relative w-[250px] mb-12">

                    <x-player-card :player="$player" />

                    @if(isset($this->playerStatuses[$player->id]))
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 z-30">
                            <x-status-badge
                                :status="$this->playerStatuses[$player->id]"
                                class="backdrop-blur-md whitespace-nowrap" />
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @endif
</div>
