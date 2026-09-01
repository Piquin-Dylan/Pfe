<?php

use App\Actions\Match\SaveConvocation;
use App\Models\Game;
use Livewire\Component;

new class extends Component {

    public Game $match;

    public array $checked = [];

    public int $maxPlayers = 16;

    public function getPlayersProperty()
    {
        $team = Auth::user()->currentTeam();

        if (!$team) {
            return collect();
        }

        return $team->players()->with('user')->get();
    }

    public function saveConvocation(): void
    {
        (new SaveConvocation())->handle($this->match, $this->checked);

        $this->dispatch('notify', message: 'Convocations enregistrées avec succès.', type: 'success');
    }

};
?>

<div>

    <div class="text-white text-center pb-6">
        Nombre de joueurs convoqués :

        @if(count($checked) >= $maxPlayers)
            <span class="text-red-400 font-bold">
                {{ count($checked) }} / {{ $maxPlayers }}
            </span>
        @else
            {{ count($checked) }} / {{ $maxPlayers }}
        @endif
    </div>

    <div class="flex justify-center pb-8">
        @if($match->players->isEmpty())

            <button
                wire:click="saveConvocation"
                @disabled(count($checked) > $maxPlayers)
                class="btn-form disabled:opacity-50 disabled:cursor-not-allowed">
                Enregistrer les convocations
            </button>

        @else

            <div class="flex flex-col items-center gap-3">

                <button
                    disabled
                    class="bg-gray-500/30 text-gray-300 px-6 py-3 rounded-2xl
        cursor-not-allowed border border-gray-500/30"
                >
                    Convocation déjà enregistrée
                </button>

                <p class="text-white/70 text-sm text-center">
                    Pour convoquer d'autres joueurs, rendez-vous dans l'onglet
                    <button
                        type="button"
                        @click="currentTab = 'second'"
                        class="text-violet-300 underline hover:text-violet-200 cursor-pointer">
                        Feuille de match
                    </button>.
                </p>

            </div>

        @endif
    </div>

    <div class="flex justify-center gap-16 flex-wrap">

        @foreach($this->players as $player)

            <label class="cursor-pointer group flex flex-col items-center">

                <div class="relative w-[250px]">
                    <x-player-card :player="$player" />
                </div>

                <input
                    wire:model.live="checked"
                    type="checkbox"
                    value="{{ $player->id }}"

                    @disabled(
                        count($checked) >= $maxPlayers
                        && !in_array($player->id, $checked)
                    )class="mt-4 h-6 w-6 accent-indigo-500 disabled:opacity-30 disabled:cursor-not-allowed"/>

            </label>

        @endforeach

    </div>

    <div class="fixed bottom-6 right-6 z-50">

        <div
            class="bg-[#23294A] border border-violet-500/30
    shadow-2xl rounded-2xl px-6 py-4 backdrop-blur-md">

            <div class="flex items-center gap-4">

                <div class="flex flex-col">

            <span class="text-violet-300 text-sm uppercase tracking-wider">
                Joueurs sélectionnés
            </span>

                    <span class="text-white text-2xl font-bold">
                {{ count($checked) }} / {{ $maxPlayers }}
            </span>

                </div>

                @if(count($checked) >= $maxPlayers)

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
