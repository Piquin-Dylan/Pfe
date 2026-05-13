<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use Livewire\Component;

new class extends Component {

    public Game $games;

    public array $checked = [];

    public string $searchPlayer = "";

    public string $filters = 'tout';

    public int $newValue = 16;

    public function mount($id): void
    {
        $this->games = Game::findOrFail($id);
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

};
?>

<div>

    <h3 class="title_section " id="tuto">
        Match du
        {{ \Carbon\Carbon::parse($games->date_match)->locale('fr')->translatedFormat('d F') }}
        : {{$games->address}}
    </h3>

    <div class="flex justify-center items-center gap-12 pt-4 pb-8" id="affiche">

        <div class="text-center">
            <img class="w-24 lg:w-42 mb-6" alt="" src="{{asset($games->photo_home)}}">
            <span class="text-center text-white text-2xl ">
                {{$games->name_home}}
            </span>
        </div>

        <span class="text-2xl text-white flex justify-center">
            {{$games->hours}}
        </span>

        <div class="text-center">
            <img class="w-24 lg:w-42 mb-6" alt="" src="{{asset($games->photo_away)}}">
            <span class="text-center text-white text-2xl ">
                {{$games->name_away}}
            </span>
        </div>

    </div>

    <div class="pr-5 pl-5">
        <input
            class="bg-white p-4 rounded-2xl w-full"
            wire:model.live.debounce="searchPlayer"
            placeholder="rechercher un joueur"
        >
    </div>

    <div class="lg:flex lg:gap-8 lg:justify-center lg:pb-8">

        <div class="flex flex-row justify-center items-center gap-5 lg:gap-12 pt-6 sm:flex-row">

            <span
                class="filter_position {{ $filters === 'tout' ? 'active' : '' }}"
                wire:click="filter('tout')">
                Tout
            </span>

            <span
                class="filter_position {{ $filters === 'attaquant' ? 'active' : '' }}"
                wire:click="filter('attaquant')">
                Attaquant
            </span>

            <span
                class="filter_position {{ $filters === 'milieux' ? 'active' : '' }}"
                wire:click="filter('milieux')">
                Milieux
            </span>

        </div>

        <div class="flex flex-row justify-center items-center pt-6 pb-6 gap-5 lg:pb-0 lg:gap-12">

            <span
                class="filter_position {{ $filters === 'defenseur' ? 'active' : '' }}"
                wire:click="filter('defenseur')">
                Défenseur
            </span>

            <span
                class="filter_position {{ $filters === 'gardien' ? 'active' : '' }}"
                wire:click="filter('gardien')">
                Gardien
            </span>
        </div>

    </div>

    <div x-data="{ currentTab: 'first' }">
        @include('livewire.components.navigation_match')
        <div x-show="currentTab === 'first'">
            <div class="text-white text-center pb-6">
                Nombre de joueurs convoqués :
                {{ count($checked) }} / {{ $newValue }}
            </div>

            <div class="flex justify-center pb-8">
                <button
                    wire:click="saveConvocation"
                    class="btn-form">
                    Enregistrer les convocations
                </button>
            </div>

            <div class="flex justify-center gap-16 flex-wrap">
                @foreach($this->players as $player)
                    <label class="cursor-pointer group flex flex-col items-center">
                        <div
                            class="relative transition-all duration-300 ease-in-out
                       group-hover:scale-105 group-hover:-translate-y-2
                       group-hover:drop-shadow-[0_0_25px_rgba(255,255,255,0.25)]"
                        >
                <span class="text-white absolute font-bold text-xl left-8 top-8 z-10">
                    {{ $player->id }}
                </span>

                            <div
                                class="absolute inset-0 rounded-2xl border-4 border-transparent
                           peer-checked:border-indigo-500
                           transition-all duration-300"
                            ></div>

                            <img
                                class="w-[250px] pb-6 transition-all duration-300
                           group-hover:brightness-110"
                                src="{{ asset('Component_card_player.svg') }}"
                                alt="">
                        </div>

                        <input
                            wire:model.live="checked"
                            type="checkbox"
                            value="{{ $player->id }}"
                            class="mt-4 h-6 w-6 accent-indigo-500">
                    </label>
                @endforeach
            </div>
        </div>

        <div x-show="currentTab === 'second'" class="flex flex-wrap justify-center gap-8">
            @foreach($this->games->players as $player)
                <div class="relative">
            <span class="text-white absolute font-bold text-xl left-8 top-8 z-10">
                {{ $player->name }}
            </span>

                    <img
                        class="w-[250px] pb-4"
                        src="{{ asset('Component_card_player.svg') }}"
                        alt=""
                    >

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
        </div>
        <div x-show="currentTab === 'third'">
            @foreach($this->games->players as $player)
                @if($player->pivot->status === "present")
                    <span class="text-white">
                {{$player->firstName}}
            </span>
                @endif

            @endforeach


        </div>
    </div>
</div>
