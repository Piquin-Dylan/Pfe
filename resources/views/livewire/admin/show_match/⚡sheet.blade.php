<?php

use App\Actions\Match\SaveConvocation;
use App\Models\Game;
use App\Models\Player;
use Livewire\Component;

new class extends Component {

    public Game $match;

    public array $checkedSecondConvocation = [];

    public function getCountPresentPlayersProperty(): int
    {
        return $this->match->players->filter(fn ($player) => $player->pivot->status === 'present')->count();
    }

    public function getPlayersNotConvokedProperty()
    {
        $convokedIds = $this->match->players->pluck('id');

        return Player::whereNotIn('id', $convokedIds)
            ->where('team_id', $this->match->team_id)
            ->get();
    }

    public function saveSecondConvocation(): void
    {
        (new SaveConvocation())->handle($this->match, $this->checkedSecondConvocation, append: true);

        $this->reset('checkedSecondConvocation');

        $this->dispatch('notify', message: 'Reconvocation enregistrée avec succès.', type: 'success');
    }

};
?>

<div x-data="{ openModal: false }" class="flex flex-wrap justify-center gap-8">

    <div class="w-full flex flex-col items-center pb-10 gap-6">

        <div class="bg-[#23294A] border border-violet-500/30 rounded-2xl px-8 py-4 shadow-lg">
            <div class="text-center">
                <p class="text-violet-300 text-lg font-medium uppercase tracking-wider">
                    Nombre de joueurs présents
                </p>

                <span class="text-white text-5xl font-bold">
                    {{ $this->countPresentPlayers }}
                </span>
            </div>
        </div>

        <button
            @click="openModal = true"
            class="btn-primary">
            Reconvoquer les joueurs
        </button>

    </div>

    @foreach($match->players as $player)

        <label class="cursor-pointer group flex flex-col items-center">

            <div class="relative w-[250px]">
                <x-player-card :player="$player" />
            </div>

            <div class="flex justify-center mt-2">
                <x-status-badge :status="$player->pivot->status" />
            </div>

        </label>

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
                    class="text-white text-2xl hover:text-violet-400 transition cursor-pointer">
                    ✕
                </button>
            </div>

            <div class="overflow-y-auto p-4 sm:p-6 flex flex-col gap-4">

                @foreach($this->playersNotConvoked as $player)

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
                            class=" h-6 w-6 accent-violet-500 shrink-0">

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
