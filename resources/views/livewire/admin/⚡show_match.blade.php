<?php

use App\Models\Game;
use Livewire\Component;

new class extends Component {

    public Game $games;

    public function mount($id): void
    {
        $this->games = Game::findOrFail($id);

    }
};
?>

<div>
    <h3 class="title_section">Match
        du {{\Carbon\Carbon::parse($games->date_match)->locale('fr')->translatedFormat('d F')}}
        : {{$games->address}}</h3>
    <div class="flex justify-center items-center gap-12 pt-4 pb-8">
        <div class="text-center">
            <img class="w-24 lg:w-42 mb-6" alt="" src="{{asset($games->photo_home)}}">
            <span class="text-center text-white text-2xl ">{{$games->name_home}}</span>
        </div>
        <span class="text-2xl text-white flex justify-center">{{$games->hours}}</span>
        <div class="text-center">
            <img class="w-24 lg:w-42 mb-6" alt="" src="{{asset($games->photo_away)}}">
            <span class="text-center text-white text-2xl ">{{$games->name_away}}</span>
        </div>

    </div>
    <div class="flex justify-center items-center gap-4 mb-10">
        <a class="btn-form" href="match/{{$games->id}}">Convocation</a>
        <x-button>Score du match</x-button>
    </div>
    <livewire:admin.team :is-match="true"></livewire:admin.team>

</div>
