<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use Livewire\Component;

new class extends Component {
    public \Illuminate\Support\Collection $trains;

    public function mount(): void
    {

        $current_user = Auth::user()->id;


        if (Auth::user()->player) {
            $player = Player::where('user_id', $current_user)->select('team_id')->value('team_id');
            $this->trains = Train::where('team_id', $player)->select('id')->get('id');
        } else {
            $team = Team::where('user_id', $current_user)->select('id')->value('id');
            $this->trains = Train::where('team_id', $team)->select('id')->get('id');
        }
    }
};
?>

<div>
    @foreach($trains as $train)
        <a href="#">
            <div class="text-5xl text-white flex justify-center">{{$train->id}}</div>
        </a>
    @endforeach</div>
