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


        //code sur le tuto
        if (Auth::user()->tutorial()->where('tutorial_name', 'match_list')->exists()) {
            $this->showTutorial = false;
        } else {
            $this->showTutorial = true;
            \App\Models\Tutorial::create([
                'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
                'tutorial_name' => "match_list",
                'seen' => true
            ]);
            $this->dispatch('start-match-list-tutorial');
        }
    }
};
?>

<div>
    @if($games->isEmpty())
        <div class="max-w-2xl mx-auto mt-10 p-8 rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">
                Aucun match n'a encore été créer pour le moment
            </h3>

            <p class="text-gray-300 mb-6">
                créer dés maintenant votre premier match dans la page calendrier
            </p>

            <a href="{{route('calendrier')}}" class="btn-primary">Créer mon premier match</a>
        </div>
    @else
        @foreach($games as $game)

            <h2 id="address" class="title_section">
                Match du {{ \Carbon\Carbon::parse($game->date_match)->locale('fr')->translatedFormat('d F') }}
                : {{ $game->address }}
            </h2>

            <div id="affiche" class="grid grid-cols-[1fr_auto_1fr] items-start gap-6 pt-4 pb-8">

                <div class="flex flex-col items-center text-center min-w-0">
                    <img
                            class="w-24 lg:w-42 mb-6"
                            alt=""
                            src="{{ asset($game->photo_home) }}"
                    >

                    <span class="text-white text-xl max-w-[220px] break-words leading-tight">
                    {{ $game->name_home }}
                </span>
                </div>

                <div class="flex items-center justify-center h-full">
                <span class="text-2xl text-white font-semibold whitespace-nowrap">
                    {{ $game->hours }}
                </span>
                </div>

                <div class="flex flex-col items-center text-center min-w-0">
                    <img
                            class="w-24 lg:w-42 mb-6"
                            alt=""
                            src="{{ asset($game->photo_away) }}"
                    >

                    <span class="text-white text-xl max-w-[220px] break-words leading-tight">
                    {{ $game->name_away }}
                </span>
                </div>

            </div>

            <div class="flex justify-center items-center gap-4 mb-10">
                @unless(Auth::user()->player)
                    <a id="cta_convocation" class="btn-primary" href="match/{{ $game->id }}">
                        Convocation
                    </a>

                    <a class="btn-secondary">
                        Score du match
                    </a>
                @endunless
            </div>

        @endforeach
    @endif
</div>
