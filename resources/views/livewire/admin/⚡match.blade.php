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
    <div class="w-full flex justify-center max-w-[250px] mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('admin.create_event')
    </div>
    @if($games->isEmpty())
        <div class="max-w-2xl mx-auto mt-10 p-6 sm:p-8 rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-xl sm:text-2xl font-bold text-white mb-4">
                Aucun match n'a encore été créer pour le moment
            </h3>

            <p class="text-sm sm:text-base text-gray-300 mb-6">
                créer dés maintenant votre premier match dans la page calendrier
            </p>

            <a href="{{route('calendrier')}}" class="btn-primary">Créer mon premier match</a>
        </div>
    @else
        @foreach($games as $game)

            <h2 id="address" class="title_section px-4 text-center break-words lg:text-left">
                Match du {{ \Carbon\Carbon::parse($game->date_match)->locale('fr')->translatedFormat('d F') }}
                : {{ $game->address }}
            </h2>

            <div id="affiche" class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-4 md:gap-8 pt-4 pb-8">

                <div class="flex flex-col items-center text-center min-w-0">
                    <div
                        class="flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 mb-3 sm:mb-6">
                        @php
                            $team = Auth::user()->team ?? Auth::user()->player?->team;
                        @endphp
                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe domicile"
                            src="{{ asset('storage/' .  $team->logo) }}"
                            srcset="
                    {{ asset('storage/' .  $team->logo) }} 128w,
                    {{ asset('storage/' .  $team->logo) }} 256w,
                   {{ asset('storage/' .  $team->logo) }} 512w
                "
                            sizes="(max-width: 640px) 64px,
                       (max-width: 768px) 80px,
                       (max-width: 1024px) 128px,
                       160px"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>

                    <span
                        class="text-white text-sm sm:text-base md:text-xl max-w-[100px] sm:max-w-[140px] md:max-w-[220px] break-words leading-tight">
            {{  $team->name }}
        </span>
                </div>

                <div class="flex items-center justify-center h-full">
        <span class="text-lg sm:text-xl md:text-3xl text-white font-semibold whitespace-nowrap">
            @if($game->score_home !== null && $game->score_away !== null)
                <span>{{ $game->score_home }} - {{ $game->score_away }}</span>
            @else
                {{ $game->hours }}
            @endif
        </span>
                </div>

                <div class="flex flex-col items-center text-center min-w-0">
                    <div
                        class="flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 mb-3 sm:mb-6">
                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe extérieur"
                            src="{{ asset('storage/' . $game->photo_away) }}"
                            srcset="
                    {{ asset('storage/' . $game->photo_away) }}128w,
                   {{ asset('storage/' . $game->photo_away) }} 256w,
                    {{ asset('storage/' . $game->photo_away) }} 512w
                "
                            sizes="(max-width: 640px) 64px,
                       (max-width: 768px) 80px,
                       (max-width: 1024px) 128px,
                       160px"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>

                    <span
                        class="text-white text-sm sm:text-base md:text-xl max-w-[100px] sm:max-w-[140px] md:max-w-[220px] break-words leading-tight">
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
                <div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-4 mb-10">

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
                        class="relative w-full max-w-md lg:max-w-2xl max-h-[90vh] overflow-y-auto rounded-[2rem] border border-white/20 bg-[#141B34] px-4 py-6 sm:px-8 sm:py-8 shadow-[0_0_80px_rgba(79,70,229,0.15)]">

                        <button
                            @click="openScoreModal = false"
                            class="absolute right-4 top-4 text-3xl sm:text-5xl font-light text-white transition hover:scale-110">
                            ×
                        </button>

                        <h2 class="pb-8 sm:pb-12 text-center text-2xl sm:text-3xl font-black text-white">
                            Résultat du match
                        </h2>

                        <div
                            class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-10 pb-10 sm:pb-14">

                            <div class="flex flex-col items-center gap-4 sm:gap-6">

                                <img
                                    class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                                    src="{{ asset('storage/' .  $team->logo) }}"
                                    srcset="{{ asset('storage/' . $team->logo) }} 96w,{{ asset('storage/' .  $team->logo) }} 192w,{{ asset('storage/' . $team->logo) }} 384w"
                                    sizes="(max-width: 640px) 80px, (max-width: 1024px) 96px, 128px"
                                    alt="Logo équipe domicile"
                                    loading="lazy"
                                    decoding="async"
                                />

                                <span
                                    class="text-center text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white">
                                    {{  $team->name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-4 md:gap-6">
                                <input
                                    wire:model="score_home"
                                    type="number"
                                    min="0"
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-transparent bg-white text-center text-2xl sm:text-3xl font-black outline-none transition focus:border-violet-500">
                                <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-white">-</span>
                                <input
                                    wire:model="score_away"
                                    type="number"
                                    min="0"
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-transparent bg-white text-center text-2xl sm:text-3xl font-black outline-none transition focus:border-violet-500">
                            </div>
                            <div class="flex flex-col items-center gap-4 sm:gap-6">
                                <img
                                    class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                                    src="{{ asset('storage/' . $game->photo_away) }}"
                                    srcset="{{ asset('storage/' . $game->photo_away) }} 96w,{{ asset('storage/' . $game->photo_away) }} 192w,{{ asset('storage/' . $game->photo_away) }} 384w"
                                    sizes="(max-width: 640px) 80px, (max-width: 1024px) 96px, 128px"
                                    alt="Logo équipe extérieur" loading="lazy" decoding="async"/>
                                <span
                                    class="text-center text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white">
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
