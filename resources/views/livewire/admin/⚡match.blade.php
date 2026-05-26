<?php

use App\Models\Game;
use App\Models\Team;
use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $games;

    public int $score_home;
    public int $score_away;

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

    public function updateScore($id)
    {
        Game::where('id', $id)->update([
            'score_home' => $this->score_home,
            'score_away' => $this->score_away
        ]);
        $this->dispatch('score-updated');
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
                    <div class="flex items-center justify-center w-28 h-28 sm:w-36 sm:h-36 lg:w-40 lg:h-40 mb-6">
                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe domicile"
                            src="{{ asset($game->photo_home) }}"
                            srcset="
                                {{ asset($game->photo_home) }} 128w,
                                {{ asset($game->photo_home) }} 256w,
                                {{ asset($game->photo_home) }} 512w
                            "
                            sizes="(max-width: 640px) 112px,
                                   (max-width: 1024px) 144px,
                                   160px"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>

                    <span class="text-white text-xl max-w-[220px] break-words leading-tight">
                        {{ $game->name_home }}
                    </span>
                </div>

                <div class="flex items-center justify-center h-full">
                    <span class="text-2xl text-white font-semibold whitespace-nowrap">
                        @if($game->score_home !== null && $game->score_away !== null)
                            <span class="text-2xl">{{ $game->score_home }} - {{ $game->score_away }}</span>
                        @else
                            {{ $game->hours }}
                        @endif
                    </span>
                </div>

                <div class="flex flex-col items-center text-center min-w-0">
                    <div class="flex items-center justify-center w-28 h-28 sm:w-36 sm:h-36 lg:w-40 lg:h-40 mb-6">
                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe extérieur"
                            src="{{ asset($game->photo_away) }}"
                            srcset="
                                {{ asset($game->photo_away) }} 128w,
                                {{ asset($game->photo_away) }} 256w,
                                {{ asset($game->photo_away) }} 512w
                            "
                            sizes="(max-width: 640px) 112px,
                                   (max-width: 1024px) 144px,
                                   160px"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>

                    <span class="text-white text-xl max-w-[220px] break-words leading-tight">
                        {{ $game->name_away }}
                    </span>
                </div>

            </div>

            <div
                x-data="{openScoreModal: false,
       showToast: false
    }"

                x-on:score-updated.window="
        openScoreModal = false;

        showToast = true;

        setTimeout(() => {
            showToast = false
        }, 3000)
    ">
                <div class="flex justify-center items-center gap-4 mb-10">

                    @unless(Auth::user()->player)

                        <a id="cta_convocation" class="btn-primary" href="match/{{ $game->id }}">
                            Convocation
                        </a>
                        <button @click="openScoreModal = true" class="btn-secondary">
                            Score du match
                        </button>
                    @endunless
                </div>

                <div
                    x-show="openScoreModal"
                    x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
                    style="display: none;">

                    <div
                        @click.away="openScoreModal = false"
                        class="relative w-full max-w-2xl overflow-hidden rounded-[2rem] border border-white/20 bg-[#141B34] px-4 py-6 sm:px-8 sm:py-8 shadow-[0_0_80px_rgba(79,70,229,0.15)]">
                        <button
                            @click="openScoreModal = false"
                            class="absolute right-4 top-4 text-3xl font-light text-white transition hover:scale-110 sm:text-5xl">
                            ×
                        </button>

                        <h2 class="pb-8 text-center text-3xl font-black text-white sm:pb-12 sm:text-2xl ">
                            Résultat du match
                        </h2>

                        <div
                            class="flex items-center justify-center gap-6 sm:gap-10 pb-10 sm:pb-14">
                            <div class="flex flex-col items-center gap-4 sm:gap-6">

                                <img
                                    class="w-24 h-24 sm:w-32 sm:h-32 lg:w-28 lg:h-28 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                                    src="{{ asset($game->photo_home) }}"
                                    srcset="{{ asset($game->photo_home) }} 96w,{{ asset($game->photo_home) }} 192w,{{ asset($game->photo_home) }} 384w"
                                    sizes="(max-width: 640px) 96px, (max-width: 1024px) 128px, 112px"
                                    alt="Logo équipe domicile"
                                    loading="lazy"
                                    decoding="async"
                                />

                                <span class="text-center text-lg font-bold text-white sm:text-xl lg:text-2xl">
                                    {{ $game->name_home }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3 sm:gap-6 lg:gap-8">
                                <input wire:model="score_home" type="number" min="0"
                                       class="h-20 w-20 rounded-full border-4 border-transparent bg-white text-center text-3xl font-black outline-none transition focus:border-violet-500 sm:h-18 sm:w-18 sm:text-4xl lg:h-20 lg:w-20 lg:text-5xl">

                                <span class="text-3xl font-black text-white sm:text-4xl lg:text-5xl">
                                    -
                                </span>

                                <input wire:model="score_away" type="number" min="0"
                                       class="h-20 w-20 rounded-full border-4 border-transparent bg-white text-center text-3xl font-black outline-none transition focus:border-violet-500 sm:h-18 sm:w-18 sm:text-4xl lg:h-20 lg:w-20 lg:text-5xl">
                            </div>

                            <div class="flex flex-col items-center gap-4 sm:gap-6">
                                <img
                                    class="w-24 h-24 sm:w-32 sm:h-32 lg:w-28 lg:h-28 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                                    src="{{ asset($game->photo_away) }}"
                                    srcset="{{ asset($game->photo_away) }} 96w,{{ asset($game->photo_away) }} 192w,{{ asset($game->photo_away) }} 384w"
                                    sizes="(max-width: 640px) 96px, (max-width: 1024px) 128px, 112px"
                                    alt="Logo équipe extérieur"
                                    loading="lazy"
                                    decoding="async"
                                />

                                <span class="text-center text-lg font-bold text-white sm:text-xl lg:text-2xl">
                                    {{ $game->name_away }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <button wire:click="updateScore({{$game->id}})" class="btn-form">
                                Confirmer
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @endif
</div>
