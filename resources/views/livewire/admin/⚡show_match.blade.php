<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use Livewire\Component;


new class extends Component {

    public Game $games;

    public array $checked = [];
    public array $checkedSecondConvocation = [];

    public string $searchPlayer = "";

    public string $filters = 'tout';

    public int $newValue = 16;

    public string $match_composition = "4-4-2";

    public array $player_position = [];


    public int $count_player = 0;


    public bool $showTutorial = true;


    public function mount($id): void

    {
        $this->games = Game::findOrFail($id);
        $this->countPresentPlayers();


        if (Auth::user()->tutorial()->where('tutorial_name', 'match_convocation')->exists()) {
            $this->showTutorial = false;
        } else {
            $this->showTutorial = true;
            \App\Models\Tutorial::create([
                'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
                'tutorial_name' => "match_convocation",
                'seen' => true
            ]);
            $this->dispatch('start-match-tutorial');
        }

    }

    public function countPresentPlayers(): void
    {
        foreach ($this->games->players as $player)
            if ($player->pivot->status === 'present') {
                $this->count_player++;
            }
    }


    public function filter($string): void
    {
        $this->filters = $string;
    }

    public function getPlayersProperty()
    {
        $current_user = Auth::id();

        return Player::where(function ($query) use ($current_user) {

            $query->whereHas('team', function ($q) use ($current_user) {
                $q->where('user_id', $current_user);
            });

            if (Auth::user()->player) {
                $teamId = Auth::user()->player->team->id;

                $query->orWhere('team_id', $teamId);

            }

        })
            ->when($this->searchPlayer, function ($query) {
                $query->where('name', 'like', '%' . $this->searchPlayer . '%');
            })
            ->when($this->filters != "tout", function ($query) {
                $query->where('players.position', '=', $this->filters);
            })
            ->get();
    }

    public function saveConvocation(): void
    {
        $players_array = [];

        foreach ($this->checked as $player) {
            $players_array[$player] = ['status' => 'en attente'];
        }
        $this->games->players()->sync($players_array);


        $players_list = DB::table('players')
            ->whereIn('players.id', $this->checked)
            ->pluck('user_id');

        $users = User::whereIn('users.id', $players_list)->get();
        Notification::send($users, new \App\Notifications\NewMatchConvocation($this->games));

    }

    public function saveSecondConvocation(): void
    {
        $players_array = [];

        foreach ($this->checkedSecondConvocation as $player) {
            $players_array[$player] = ['status' => 'en attente'];
        }
        $this->games->players()->attach($players_array);


        $players_list = DB::table('players')
            ->whereIn('players.id', $this->checkedSecondConvocation)
            ->pluck('user_id');

        $users = User::whereIn('users.id', $players_list)->get();
        Notification::send($users, new \App\Notifications\NewMatchConvocation($this->games));

    }

    public function assignPlayerToPosition($poste, $idPlayer)
    {
        $alreadyAssigned = collect($this->player_position)
            ->contains($idPlayer);

        if ($alreadyAssigned && ($this->player_position[$poste] ?? null) !== $idPlayer) {
            return;
        }

        $this->player_position[$poste] = $idPlayer;
    }

};
?>

<div>

    <h3 class="title_section " id="tuto">
        Match du
        {{ \Carbon\Carbon::parse($games->date_match)->locale('fr')->translatedFormat('d F') }}
        : {{$games->address}}
    </h3>

    <div class="grid grid-cols-[1fr_auto_1fr] items-start gap-6 pt-4 pb-8" id="affiche">

        <div class="flex flex-col items-center text-center min-w-0">
            <img
                class="w-24 lg:w-42 mb-6"
                alt=""
                src="{{ asset('storage/' . $games->photo_home) }}"
            >

            <span class="text-white text-2xl max-w-[220px] break-words leading-tight">
            {{ $games->name_home }}
        </span>
        </div>

        <div class="flex items-center justify-center h-full">
        <span class="text-2xl text-white font-semibold whitespace-nowrap">
            {{ $games->hours }}
        </span>
        </div>

        <div class="flex flex-col items-center text-center min-w-0">
            <img
                class="w-24 lg:w-42 mb-6"
                alt=""
                src="{{ asset('storage/' . $games->photo_away) }}"
            >

            <span class="text-white text-2xl max-w-[220px] break-words leading-tight">
            {{ $games->name_away }}
        </span>
        </div>

    </div>

    <div x-data="{ currentTab: 'first' }">
        @include('livewire.components.navigation_match')
        <div x-show="currentTab === 'first'">

            <div class="text-white text-center pb-6">
                Nombre de joueurs convoqués :

                @if(count($checked) >= $newValue)

                    <span class="text-red-400 font-bold">
                {{ count($checked) }} / {{ $newValue }}
            </span>

                @else

                    {{ count($checked) }} / {{ $newValue }}

                @endif
            </div>

            <div class="flex justify-center pb-8">
                @if($this->games->players->isEmpty())

                    <button
                        wire:click="saveConvocation"
                        @disabled(count($checked) > $newValue)
                        class="btn-form disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Enregistrer les convocations
                    </button>

                @else

                    <button
                        disabled
                        class="bg-gray-500/30 text-gray-300 px-6 py-3 rounded-2xl
        cursor-not-allowed border border-gray-500/30"
                    >
                        Convocation déjà enregistrée
                    </button>

                @endif
            </div>

            <div class="flex justify-center gap-16 flex-wrap">

                @foreach($this->players as $player)

                    <label class="cursor-pointer group flex flex-col items-center">

                        <div class="relative w-[250px]">
                    <span
                        class="absolute z-30 text-white font-bold text-xl
                       left-2 top-6">{{ $player->firstName }}</span>
                            <span
                                class="absolute z-30 text-white font-bold text-xl
                       left-2 top-80">{{ $player->position }}</span>
                            <img class="absolute z-20 inset-0  w-full h-full  object-cover"
                                 style="
                    clip-path: polygon(
                        13% 15%,
                        52% 15%,
                        60% 7%,
                        86% 7%,
                        92% 12%,
                        92% 88%,
                        85% 94%,
                        50% 94%,
                        42% 84%,
                        13% 84%
                    );
                " src="{{ asset('1000017766.jpg') }}" alt="">
                            <div
                                class="absolute z-30 bottom-[60px] right-[28px]  w-[55px] h-[55px  rounded-full  bg-[#A6463A]  flex items-center justify-center text-white text-4xl font-bold">
                                {{$player->maillot}}
                            </div>
                            <img
                                class="relative z-10 w-full"
                                src="{{ asset('Component_card_player.svg') }}"
                                alt="">
                        </div>


                        <input
                            wire:model.live="checked"
                            type="checkbox"
                            value="{{ $player->id }}"

                            @disabled(
                                count($checked) >= $newValue
                                && !in_array($player->id, $checked)
                            )class="mt-4 h-6 w-6 accent-indigo-500 disabled:opacity-30 disabled:cursor-not-allowed"/>


                    </label>

                @endforeach

            </div>


            <div class="fixed bottom-6 right-6 z-50">

                <div
                    class="bg-[#23294A] border border-violet-500/30
            shadow-2xl rounded-2xl px-6 py-4 backdrop-blur-md"
                >

                    <div class="flex items-center gap-4">

                        <div class="flex flex-col">

                    <span class="text-violet-300 text-sm uppercase tracking-wider">
                        Joueurs sélectionnés
                    </span>

                            <span class="text-white text-2xl font-bold">
                        {{ count($checked) }} / {{ $newValue }}
                    </span>

                        </div>

                        @if(count($checked) >= $newValue)

                            <div class="animate-pulse">

                        <span
                            class="bg-red-500/20 text-red-400 border border-red-500/40
                            px-3 py-1 rounded-full text-sm font-bold uppercase"
                        >
                            Nombre de joueur max atteinte
                        </span>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <div x-data="{ openModal: false }">

            <div x-show="currentTab === 'second'" class="flex flex-wrap justify-center gap-8">

                <div class="w-full flex flex-col items-center pb-10 gap-6">

                    <div class="bg-[#23294A] border border-violet-500/30 rounded-2xl px-8 py-4 shadow-lg">
                        <div class="text-center">
                            <p class="text-violet-300 text-lg font-medium uppercase tracking-wider">
                                Nombre de joueurs présents
                            </p>

                            <span class="text-white text-5xl font-bold">
                            {{ $this->count_player }}
                        </span>
                        </div>
                    </div>

                    <button
                        @click="openModal = true"
                        class="btn-primary">
                        Reconvoquer les joueurs
                    </button>

                </div>

                @php
                    $playerId = $this->games->players->pluck('id');

                    $playersNotConvoked = \App\Models\Player::whereNotIn('players.id', $playerId)
                        ->where('team_id', $this->games->players->first()?->team_id)
                        ->get();
                @endphp

                @foreach($this->games->players as $player)

                    <div class="relative w-[250px]">
                    <span
                        class="absolute z-30 text-white font-bold text-xl
                       left-2 top-6">{{ $player->firstName }}</span>
                        <span
                            class="absolute z-30 text-white font-bold text-xl
                       left-2 top-80">{{ $player->position }}</span>
                        <img class="absolute z-20 inset-0  w-full h-[380px]  object-cover"
                             style="
                    clip-path: polygon(
                        13% 15%,
                        52% 15%,
                        60% 7%,
                        86% 7%,
                        92% 12%,
                        92% 88%,
                        85% 94%,
                        50% 94%,
                        42% 84%,
                        13% 84%
                    );
                " src="{{ asset($player->photo) }}" alt="">
                        <div
                            class="absolute z-30 bottom-[60px] right-[28px]  w-[55px] h-[55px  rounded-full  bg-[#A6463A]  flex items-center justify-center text-white text-4xl font-bold">
                            {{$player->maillot}}
                        </div>
                        <img
                            class="relative z-10 w-full"
                            src="{{ asset('Component_card_player.svg') }}"
                            alt="">

                        <div class="flex justify-center">
                        <span
                            @class([
                                'px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wide border',
                                'bg-green-500/20 text-green-400 border-green-500/40' => $player->pivot->status === 'present',
                                'bg-red-500/20 text-red-400 border-red-500/40' => $player->pivot->status === 'absent',
                                'bg-orange-500/20 text-orange-400 border-orange-500/40' => $player->pivot->status === 'en attente',
                            ])
                        >
                            {{ $player->pivot->status }}
                        </span>
                        </div>
                    </div>

                @endforeach

                <div
                    x-show="openModal"
                    x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
                    style="display: none;"
                >

                    <div
                        @click.away="openModal = false"
                        class="bg-[#23294A] border border-violet-500/30 rounded-3xl w-full max-w-2xl shadow-2xl max-h-[90vh] overflow-hidden flex flex-col"
                    >

                        <div class="flex justify-between items-center p-6 sm:p-8 border-b border-violet-500/20">
                            <h2 class="text-white text-2xl sm:text-3xl font-bold">
                                Reconvoquer des joueurs
                            </h2>

                            <button
                                @click="openModal = false"
                                class="text-white text-2xl hover:text-violet-400 transition">
                                ✕
                            </button>
                        </div>

                        <div class="overflow-y-auto p-4 sm:p-6 flex flex-col gap-4">

                            @foreach($playersNotConvoked as $player)

                                <label
                                    class="flex items-center justify-between bg-[#1B2340]
                    border border-violet-500/20 rounded-2xl px-4 sm:px-6 py-4
                    hover:border-violet-500/50 transition cursor-pointer">

                                    <div class="flex flex-col min-w-0">
                        <span class="text-white text-lg font-semibold truncate">
                            {{ $player->firstName }}
                        </span>

                                        <span class="text-violet-300 text-sm uppercase tracking-wider">
                            {{ $player->position }}
                        </span>
                                    </div>
                                    <input
                                        wire:model.live="checkedSecondConvocation"
                                        type="checkbox"
                                        value="{{ $player->id }}"
                                        class="h-6 w-6 accent-violet-500 shrink-0">

                                </label>

                            @endforeach

                            <div class="pt-6 flex justify-end">
                                <button
                                    wire:click="saveSecondConvocation"
                                    class="btn-primary w-full sm:w-auto">
                                    Valider la reconvocation
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <x-admin.show-match.composition></x-admin.show-match.composition>
    </div>

</div>
