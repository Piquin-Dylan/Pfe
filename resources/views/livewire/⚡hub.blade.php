<?php

use App\Livewire\Forms\CreateEventForm;
use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Livewire\Component;

new class extends Component {

    public string $searchPlayer = "";
    public $teams;
    public $users;


    public function mount(): void
    {


        //on récupére les équipes de l'utilisateur actuellement connecter
        $this->teams = Auth::user()->team()->get();
        //potentiel amélioration des rêquete en utilisant les modéles éloquent
        //$this->players = Auth::user()->team()->with('players')->get();
        $current_user = Auth::user()->getAuthIdentifier();

        //   $this->team_user = DB::table('team')->select('team_id')->where('team.id', $test)->get();
        $this->users = DB::table('users')
            ->join('players', 'users.id', '=', 'players.user_id')
            ->join('team', 'team.id', '=', 'players.team_id')
            ->where('players.user_id', $current_user)
            ->select('team.name', 'players.team_id')
            ->get();


    }


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


    //Permet de pouvoir déconnecter un utilisateur qui est sur le hub en appuyant sur le bouton deconnexion
    public function logout(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
?>

<div>
    <section>

        @auth
            <div class="flex justify-center items-center gap-3  flex-col">
                <img src="{{asset('f2918708-1aed-4d65-9c03-a2f99ca01212 5.png')}}" alt="">
                <div class="flex justify-center gap-2 p-3">
                    <span class="title_section"> {{Auth::user()->firstName}}</span>
                    <span class="title_section"> {{Auth::user()->lastName}}</span>
                    <img src="{{asset(Auth::user()->image)}}">

                </div>
                <div>
                    <form wire:submit="logout" method="POST">
                        <button class="btn_deconnexion" type="submit">Deconnexion</button>
                    </form>
                    <x-modal></x-modal>
                </div>
                <span class="title_section">Mes équipes</span>
            </div>
        @endauth

        <div class="lg:flex lg:flex-row">
            @foreach($this->teams as $team)
                <div class=" card_hub flex items-center flex-col gap-8 flex-wrap ">
                    <a href="/dashboard/{{\Illuminate\Support\Facades\Auth::user()->id}}">
                        <span class="text-white">{{$team->name}}</span>
                        <span class="text-white">{{$team->division}}</span>
                        <span class="text-white">{{$team->ville}}</span>
                        <span class="text-white">{{$team->code}}</span>
                    </a>
                </div>
            @endforeach

        </div>
        <div class="lg:flex lg:flex-row">
            @foreach($this->users as $user)
                <div class=" card_hub flex items-center flex-col gap-8 flex-wrap ">

                    <span class="text-white">{{$user->name}}</span>
                </div>
            @endforeach

            <input wire:model.live.debounce="searchPlayer" placeholder="rechercher un joueur">
            {{--  permet de pouvoir afficher les noms des joueurs--}}
            @foreach($this->players as $player)
                <div class=" card_hub flex items-center flex-col gap-8 flex-wrap ">

                    <span class="text-white">{{$player->name}}</span>
                </div>
            @endforeach
        </div>

    </section>
</div>
