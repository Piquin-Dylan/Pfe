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
                $query->where('name', 'like', '%' . $this->searchPlayer . '%');
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
    <div class=" pr-5 pl-5">
        <input class="bg-white p-4 rounded-2xl w-full" wire:model.live.debounce="searchPlayer"
               placeholder="rechercher un joueur">
    </div>

    <x-admin.filter_position></x-admin.filter_position>

    <div class="flex justify-center gap-16 flex-wrap">
        @php
            $players = $playersWithStatus ?? $this->players;
        @endphp

        @foreach($players as $player)

            <div class="relative">
        <span class="text-white absolute font-bold text-xl left-8 top-8">
            {{ $player->name }}
        </span>

                <img class="w-[250px] pb-6"
                     src="{{ asset('Component_card_player.svg') }}"
                     alt="">


                @if(isset($player->pivot->status))

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
                @endif
            </div>
        @endforeach
    </div>


</div>
