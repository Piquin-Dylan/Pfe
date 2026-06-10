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
<div class="max-w-7xl mx-auto">

    <section id="stats" aria-labelledby="stats-title" class="pb-8 lg:pb-20">

        <div class="mb-8">
            <h2 id="stats-title" class="text-2xl font-bold text-white">
                Statistiques du club
            </h2>

            <p class="text-gray-400 mt-1">
                Consultez les statistiques du club
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            <x-admin.dashboard.stats_card
                :image="asset('person.svg')"
                :value="$player"
                title="Joueurs dans l’équipe"
                voir="Voir les joueurs"
                link="{{ route('team') }}"/>

            <x-admin.dashboard.stats_card
                :image="asset('ball.svg')"
                :value="$match"
                title="Matchs créés"
                voir="Voir les matchs"
                link="{{ route('match') }}"/>

            <x-admin.dashboard.stats_card
                :image="asset('calendar.svg')"
                :value="$train"
                title="Entraînements créés"
                voir="Voir les entraînements"
                link="{{ route('train') }}"/>

        </div>

        <div class="flex justify-center mt-8">
            <a class="btn-form" href="{{ route('statistiques') }}">
                Voir statistiques joueurs
            </a>
        </div>

    </section>

</div>
