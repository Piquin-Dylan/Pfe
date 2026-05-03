<?php

use App\Models\Game;
use Livewire\Component;

new class extends Component {

    public Game $game;

    public function mount($id): void
    {
        $this->game = Game::findOrFail($id);

        // $this->game->players()->get();

        // dump($this->trains->players);
    }
};
?>

<div>
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
        <a class="btn-form" href="match/{{$game->id}}">Convocation</a>
        <x-button>Score du match</x-button>
    </div>
    <livewire:admin.team></livewire:admin.team>

</div>
