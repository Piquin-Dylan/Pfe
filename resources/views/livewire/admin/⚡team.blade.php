<?php

use Livewire\Component;

new class extends Component {

    public string $searchPlayer = "";

    //Fonction qui permet de pouvoir afficher les joueurs appartenant a un club de l"utilisateur connecter qui est donc le coach du club
    public function getPlayersProperty()
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
            })
            ->select('players.name', 'players.position', 'team.id')
            ->get();
    }
};
?>

<div>

    @foreach($this->players as $player)
        {{--
           ToDo  prévoir une solution de fallback quand pour le moment aucun joueur n'a encore rejoint l'équipe
        --}}
        <div class="  card_hub flex justify-center items-center flex-col gap-8 flex-wrap ">
            <span class="text-white">{{$player->name}}</span>
        </div>
    @endforeach
</div>
