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
            $this->games = Game::where('team_id', $player)->get();
        } else {
            $team = \App\Models\Team::where('user_id', $current_user)->select('id')->value('id');
            $this->games = Game::where('team_id', $team)->get();
        }
    }
};
?>

<div>

    @foreach($games as $game)

        <div class="text-5xl text-white flex justify-center">{{$game->id}}</div>
        <img alt="" src="{{asset($game->photo_home)}}">
        <img alt="" src="{{asset($game->photo_away)}}">
    @endforeach

</div>
