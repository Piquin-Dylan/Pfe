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
            $this->trains = Train::where('team_id', $player)->get('id');
        } else {
            $team = Team::where('user_id', $current_user)->select('id')->value('id');
            $this->trains = Train::where('team_id', $team)->get();
        }
    }
};
?>

<div>
    <div class="lg:flex lg:justify-center lg:items-center lg:flex-row lg:flex-wrap lg:gap-12">
        @foreach($trains as $train)
            <div class="text-2xl text-white flex flex-col justify-center lg:w-112 lg:g-12">
                <div class="flex flex-row gap-8 mt-8 mb-8">
                    <span class="text-center bg-gray-700 rounded-2xl p-4">{{ \Carbon\Carbon::parse($train->date_train)->locale('fr')->translatedFormat('d F') }}  </span>
                    <div class="">
                        <span>Entrainement collectif</span>
                        <div class="">
                            <span class="mr-4">{{\Carbon\Carbon::parse($train->hours_start)->format('H\hi')}} - {{\Carbon\Carbon::parse($train->hours_start)->format('H\hi')}} </span>
                            <span class="">{{$train->address}} </span>
                            <a href="train/{{{$train->id}}}">Voir</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
