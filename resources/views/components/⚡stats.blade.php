<?php

use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

new class extends Component {

    public int $player;
    public int $train;
    public int $match;

    #[NoReturn]
    public function mount()
    {
        if (Auth::user()->player) {
            $this->player = Auth::user()->player->team->players()->count();
            $this->match = Auth::user()->player->games()->count();
            $this->train = Auth::user()->player->trains()->count();

        } else {
            $this->player = Auth::user()->team->players()->count();
            $this->match = Auth::user()->games()->count();
            $this->train = Auth::user()->trains()->count();
        }

    }
};
?>

<div id="stats" class=" pb-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:pb-20">

    <x-admin.dashboard.stats_card
        :image="asset('person.svg')"
        :value="$player"
        title="Joueurs dans l’équipe"
        voir="Voir les joueurs "
        link="{{route('team')}}"/>

    <x-admin.dashboard.stats_card
        :image="asset('ball.svg')"
        :value="$match"
        title="Matchs créés"
        voir="Voir les matchs "
        link="{{route('match')}}"/>

    <x-admin.dashboard.stats_card
        :image="asset('calendar.svg')"
        :value="$train"
        title="Entraînements créés"
        voir="Voir les entraînements "
        link="{{route('train')}}"/>

</div>
