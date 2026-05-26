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

    <div class="pr-5 pl-5">
        <input
            class="bg-white p-4 rounded-2xl w-full"
            wire:model.live.debounce="searchPlayer"
            placeholder="Rechercher un joueur"
        >
    </div>

    <x-admin.filter_position />

    @php
        $players = $playersWithStatus ?? $this->players;
    @endphp

    @if($players->isEmpty())
        <div class="max-w-2xl mx-auto mt-10 p-8 rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">
                Aucun joueur dans votre équipe
            </h3>

            <p class="text-gray-300 mb-6">
                Partagez ce code avec vos joueurs pour qu'ils puissent rejoindre votre équipe.
            </p>

            <div class="inline-flex items-center gap-4 bg-white/10 px-6 py-4 rounded-2xl">
                <span class="text-3xl font-bold tracking-widest text-white">
    {{ Auth::user()->team?->code ?? Auth::user()->player?->team?->code }}
</span>
            </div>
        </div>
    @else
        <div class="flex justify-center gap-16 flex-wrap">
            @foreach($players as $player)
                <div class="relative">
                    <span class="text-white absolute font-bold text-xl left-8 top-8">
                        {{ $player->name }}
                    </span>

                    <img
                        class="w-[250px] pb-6"
                        src="{{ asset('Component_card_player.svg') }}"
                        alt=""
                    >

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
    @endif
</div>
