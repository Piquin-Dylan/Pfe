<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $trains;
    public string $selectedDate = '';
    public bool $showChoiceModal = false;

    public function mount(): void
    {
        $current_user = Auth::id();

        if (Auth::user()->player) {
            $player = Player::where('user_id', $current_user)
                ->value('team_id');

            $this->trains = Train::where('team_id', $player)
                ->orderBy('date_train')
                ->get();
        } else {
            $team = Team::where('user_id', $current_user)
                ->value('id');

            $this->trains = Train::where('team_id', $team)
                ->orderBy('date_train')
                ->get();
        }
    }

    public function deleteEvent($id, $type): void
    {
        if ($type === 'train') {
            Train::destroy($id);
        }

        if ($type === 'game') {
            Game::destroy($id);
        }

        $this->dispatch('event-deleted', id: $id);
    }

    #[On('date-selected')]
    public function dateSelected($date): void
    {
        $this->selectedDate = $date;
        $this->showChoiceModal = true;
    }


    public function createGame(): void
    {
        $this->dispatch('open-create-game-modal', date: $this->selectedDate);

        $this->showChoiceModal = false;
    }

    public function createTrain(): void
    {
        $this->dispatch('open-create-train-modal', date: $this->selectedDate);

        $this->showChoiceModal = false;
    }
};
?>

<div>
    <div class="flex flex-col flex-wrap gap-4 justify-center items-center sm:flex-row">
        <livewire:admin.create_event />
        <livewire:admin.create_train />
    </div>

    <div wire:ignore>
        <x-calendar-test />
    </div>

    @if($showChoiceModal)
        <div
            x-data
            x-on:keydown.escape.window="$wire.set('showChoiceModal', false)"
            wire:click.self="$set('showChoiceModal', false)"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
        >
            <div
                class="w-full max-w-lg rounded-[24px]
                   border border-slate-700/50
                   bg-gradient-to-br from-[#0f172a] via-[#0b1735] to-[#020617]
                   shadow-2xl p-8"
            >
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-white">
                            Créer un événement
                        </h2>

                        <p class="text-slate-400 mt-1">
                            {{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}
                        </p>
                    </div>

                    <button
                        wire:click="$set('showChoiceModal', false)"
                        class="text-slate-400 hover:text-white text-3xl leading-none transition"
                    >
                        ×
                    </button>
                </div>

                <div class="grid gap-4">

                    <button
                        wire:click="createGame"
                        class="group rounded-2xl border border-blue-500/20
                           bg-blue-500/10 hover:bg-blue-500/20
                           transition-all duration-200
                           p-5 text-left"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-blue-400">
                                    ⚽ Match
                                </h3>

                                <p class="text-slate-300 mt-1">
                                    Organiser une rencontre sportive
                                </p>
                            </div>

                            <span class="text-blue-400 text-2xl group-hover:translate-x-1 transition">
                            →
                        </span>
                        </div>
                    </button>

                    <button
                        wire:click="createTrain"
                        class="group rounded-2xl border border-green-500/20
                           bg-green-500/10 hover:bg-green-500/20
                           transition-all duration-200
                           p-5 text-left"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-green-400">
                                    🏃 Entraînement
                                </h3>

                                <p class="text-slate-300 mt-1">
                                    Planifier une séance d'entraînement
                                </p>
                            </div>

                            <span class="text-green-400 text-2xl group-hover:translate-x-1 transition">
                            →
                        </span>
                        </div>
                    </button>

                </div>
            </div>
        </div>
    @endif

    <x-dialog_modal />
</div>
