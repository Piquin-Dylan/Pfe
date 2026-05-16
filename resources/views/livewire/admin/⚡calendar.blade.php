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
            $this->trains = Train::where('team_id', $player)->orderby('date_train', 'asc')->get();
        } else {
            $team = Team::where('user_id', $current_user)->select('id')->value('id');
            $this->trains = Train::where('team_id', $team)->orderby('date_train', 'asc')->get();
        }
    }
};
?>

<div>
    <x-calendar-test></x-calendar-test>
    @foreach($trains as $train)

        <x-dialog_modal link="train/{{{$train->id}}}"></x-dialog_modal>
    @endforeach

</div>
