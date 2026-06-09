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

<div class="max-w-7xl mx-auto">
    <div class="w-full flex justify-center max-w-[250px] mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('admin.create_event')
    </div>
    @if($games->isEmpty())
        <x-match.empy-match
            title="Aucun match n'a encore été créé pour le moment"
            description="Créez dès maintenant votre premier match dans la page calendrier"
            :href="route('calendrier')"
            button="Créer mon premier match"
        />
    @else
        @foreach($games as $game)

            <h2 id="address" class="title_section px-4 text-center break-words lg:text-left">
                Match du {{ \Carbon\Carbon::parse($game->date_match)->locale('fr')->translatedFormat('d F Y') }}
                : {{ $game->address }}
            </h2>

            <div id="affiche" class="grid grid-cols-[1fr_auto_1fr] items-center gap-2 sm:gap-4 md:gap-8 pt-4 pb-8">

                <div class="flex flex-col items-center text-center min-w-0">
                    <div
                        class="flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 mb-3 sm:mb-6">
                        @php
                            $team = Auth::user()->team ?? Auth::user()->player?->team;

                            $logo = in_array($team->logo, [
                                'photos/logo.png',
                                'photos/logo_club.png',
                            ])
                                ? asset($team->logo)
                                : asset('storage/' . $team->logo);
                        @endphp

                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe domicile"
                            src="{{ $logo }}"
                            srcset="  {{ $logo }} 128w,  {{ $logo }} 256w,  {{ $logo }} 512w"
                            sizes=" (max-width: 640px) 64px, (max-width: 768px) 80px, (max-width: 1024px) 128px, 160px"
                            loading="lazy" decoding="async">
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
                        @php
                            $photoAway = $game->photo_away === 'photos/logo_club.png'
                                ? asset($game->photo_away)
                                : asset('storage/' . $game->photo_away);
                        @endphp

                        <img
                            class="w-full h-full object-contain"
                            alt="Logo équipe extérieur"
                            src="{{ $photoAway }}"
                            srcset="  {{ $photoAway }} 128w,  {{ $photoAway }} 256w,  {{ $photoAway }} 512w "
                            sizes=" (max-width: 640px) 64px, (max-width: 768px) 80px, (max-width: 1024px) 128px, 160px "
                            loading="lazy"
                            decoding="async"/>
                    </div>
                    <span
                        class="text-white text-sm sm:text-base md:text-xl max-w-[100px] sm:max-w-[140px] md:max-w-[220px] break-words leading-tight">
                {{ $game->name_away }}</span>
                </div>

            </div>

            <div x-data="{openScoreModal: false,
       showToast: false
    }"

                 x-on:score-updated.window="
        openScoreModal = false;

        showToast = true;

        setTimeout(() => {
            showToast = false
        }, 3000)">
                @unless(Auth::user()->player)
                    <x-match.score
                        :game-id="$game->id"/>
                @endunless

                <x-match.modal-score
                    show="openScoreModal"
                    close="openScoreModal = false"
                    :home-logo="$team->logo"
                    :home-name="$team->name"
                    :away-logo="$game->photo_away"
                    :away-name="$game->name_away">
                    <input wire:model="score_home" type="number" min="0"
                           class="h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-transparent bg-white text-center text-2xl sm:text-3xl font-black outline-none transition focus:border-violet-500">
                    <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-white">-</span>

                    <input
                        wire:model="score_away"
                        type="number"
                        min="0"
                        class="h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-transparent bg-white text-center text-2xl sm:text-3xl font-black outline-none transition focus:border-violet-500">

                    <x-slot:footer>
                        <button wire:click="updateScore({{ $game->id }})" class="btn-form">
                            Confirmer
                        </button>
                    </x-slot:footer>
                </x-match.modal-score>
            </div>
        @endforeach
    @endif
</div>
