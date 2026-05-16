<?php

use App\Models\Game;
use App\Models\Team;
use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $games;

    public function mount(): void
    {

        $current_user = Auth::user()->id;


        if (Auth::user()->player) {
            $player = \App\Models\Player::where('user_id', $current_user)->select('team_id')->value('team_id');
            $this->games = Game::where('team_id', $player)->orderBy('date_match', 'asc')->get();
        } else {
            $team = \App\Models\Team::where('user_id', $current_user)->select('id')->value('id');
            $this->games = Game::where('team_id', $team)->orderBy('date_match', 'asc')->get();
        }
    }
};
?>

<div>

    @foreach($games as $game)

        <h3 class="title_section">Match
            du {{\Carbon\Carbon::parse($game->date_match)->locale('fr')->translatedFormat('d F')}}
            : {{$game->address}}</h3>
        <div class="flex justify-center items-center gap-12 pt-4 pb-8">
            <div class="text-center">
                <img class="w-24 lg:w-42 mb-6" alt="" src="{{asset($game->photo_home)}}">
                <span class="text-center text-white text-2xl ">{{$game->name_home}}</span>
            </div>
            <span class="text-2xl text-white flex justify-center">{{$game->hours}}</span>
            <div class="text-center">
                <img class="w-24 lg:w-42 mb-6" alt="" src="{{asset($game->photo_away)}}">
                <span class="text-center text-white text-2xl ">{{$game->name_away}}</span>
            </div>

        </div>
        <div class="flex justify-center items-center gap-4 mb-10">
            @unless(Auth::user()->player)
                <a class="btn-form" href="match/{{$game->id}}">Convocation</a>
                <x-button>Score du match</x-button>
            @endunless

        </div>
    @endforeach

</div>
