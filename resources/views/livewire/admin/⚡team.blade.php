<?php

use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

new class extends Component {

    public string $searchPlayer = "";

    public string $filters = '';


    public function filter($string): void
    {
        $this->filters = $string;
    }

    //Fonction qui permet de pouvoir afficher les joueurs appartenant a un club de l"utilisateur connecter qui est donc le coach du club
    public function getPlayersProperty(): \Illuminate\Support\Collection
    {
        $current_user = Auth::id();

        ///requete pour afficher tout les joueurs qui appartient au club du user connecter
        /// Todo améliorer les requête en utilisant plus cett méthode         $this->teams = Auth::user()->team()->get();
        return DB::table('users')
            ->join('team', 'users.id', '=', 'team.user_id')
            ->join('players', 'team.id', '=', 'players.team_id')
            ->where('team.user_id', $current_user)
            ->when($this->searchPlayer, function ($query) {
                $query->where('players.name', 'like', '%' . $this->searchPlayer . '%');
            })->when($this->filters, function ($query) {
                $query->where('players.position', '=', $this->filters);
            })
            ->select('players.name', 'players.position', 'team.id')
            ->get();

    }


};
?>

<div class="grow lg:ml-64 ">
    <h2 class="title_section p-5">Mon équipe</h2>
    <div class=" pr-5 pl-5">
        <input class="bg-white p-4 rounded-2xl w-full" wire:model.live.debounce="searchPlayer"
               placeholder="rechercher un joueur">
    </div>

    <div class="lg:flex lg:gap-8 lg:justify-center lg:pb-8">
    <div class="flex flex-row justify-center items-center gap-5 lg:gap-12 pt-6 sm:flex-row">
        <span class="filter_position" wire:click="filter('attaquant')">Attaquant</span>
        <span class="filter_position" wire:click="filter('milieux')">Milieux</span>
    </div>
    <div class="flex flex-row justify-center items-center pt-6 pb-6 gap-5 lg:pb-0 lg:gap-12">
        <span class="filter_position" wire:click="filter('defenseur')">Défenseur</span>
        <span class="filter_position" wire:click="filter('gardien')">Gardien</span>
    </div>
    </div>

    <div class="flex justify-center gap-16 flex-wrap">
        @foreach($this->players as $player)

            <div class="relative">
            <span class="text-white absolute font-bold text-xl left-8 top-8">
                {{$player->name}}
            </span>

                <img class="w-[250px] pb-6"
                     src="{{asset('Component_card_player.svg')}}"
                     alt="">
            </div>

        @endforeach
    </div>

</div>
