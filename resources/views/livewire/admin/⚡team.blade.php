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

    public Collection $playersWithStatus;

    public bool $isMatch = false;

    public int $count = 0;

    public array $checked = [];


    public function filter($string): void
    {
        $this->filters = $string;
    }

    //Fonction qui permet de pouvoir afficher les joueurs appartenant a un club de l"utilisateur connecter qui est donc le coach du club
    public function getPlayersProperty(): \Illuminate\Support\Collection
    {
        $current_user = Auth::id();


        return Player::where(function ($query) use ($current_user) {

            $query->whereHas('team', function ($q) use ($current_user) {
                $q->where('user_id', $current_user);
            });

            if (Auth::user()->player) {
                $teamId = Auth::user()->player->team->id;

                $query->orWhere('team_id', $teamId);
            }
        })
            ->when($this->searchPlayer, function ($query) {
                $query->where('firstName', 'like', '%' . $this->searchPlayer . '%');
            })
            ->when($this->filters != 'tout', function ($query) {
                $query->whereIn('players.position', $this->poste[$this->filters]);
            })
            ->with('team:id,user_id', 'trains')
            ->get();
    }

};
?>

<div class="grow">
    <h2 class="title_section p-5">Mon équipe</h2>

    <div class="pr-5 pl-5">
        <input
            class="bg-white p-4 rounded-2xl w-full"
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

        <span
            class="absolute z-30 text-white font-bold text-xl left-2 top-6">
            {{ $player->firstName }}
        </span>

                    <span
                        class="absolute z-30 text-white font-bold text-xl left-2 top-80">
            {{ $player->position }}
        </span>

                    <img
                        class="absolute z-20 inset-0 w-full h-full object-cover"
                        style="clip-path: polygon(
                13% 15%,
                52% 15%,
                60% 7%,
                86% 7%,
                92% 12%,
                92% 88%,
                85% 94%,
                50% 94%,
                42% 84%,
                13% 84%
            );"
                        src="{{ asset($player->user->image) }}"
                        alt="">

                    <div
                        class="absolute z-30 bottom-[60px] right-[28px] w-[55px] h-[55px] rounded-full bg-[#A6463A] flex items-center justify-center text-white text-4xl font-bold">
                        {{ $player->maillot }}
                    </div>

                    <img
                        class="relative z-10 w-full"
                        src="{{ asset('Component_card_player.svg') }}"
                        alt=""
                    >

                    @if(isset($player->pivot->status))
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 z-30">
                <span
                    @class([
                        'px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wide border backdrop-blur-md whitespace-nowrap',
                        'bg-green-500/20 text-green-400 border-green-500/40' => $player->pivot->status === 'present',
                        'bg-red-500/20 text-red-400 border-red-500/40' => $player->pivot->status === 'absent',
                        'bg-orange-500/20 text-orange-400 border-orange-500/40' => $player->pivot->status === 'en attente',
                    ])>
                    {{ $player->pivot->status }}
                </span>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @endif
</div>
