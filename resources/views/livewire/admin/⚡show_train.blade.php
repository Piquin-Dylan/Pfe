<?php

use App\Models\Train;
use Livewire\Component;

new class extends Component {

    public Train $trains;

    public int $count_player = 0;


    public function mount($id): void
    {
        $this->trains = Train::findOrFail($id);

        $this->trains->players()->get();

        $this->countPresentPlayers();

    }

    public function countPresentPlayers(): void
    {
        foreach ($this->trains->players as $player)
            if ($player->pivot->status === 'present') {
                $this->count_player++;
            }
    }
};
?>

<div>
    <div class="mb-4 px-4">
        <h2 class="text-white text-lg font-semibold leading-tight">
            Joueurs présents
        </h2>

        <p class="text-white/70 text-sm mt-1">
            Entraînement du
            {{ \Carbon\Carbon::parse($trains->date_train)->locale('fr')->translatedFormat('d F') }}
        </p>
    </div>

    <div class="mx-4 bg-[#23294A] border border-violet-500/30 rounded-2xl p-4 shadow-lg">
        <div class="text-center">
            <p class="text-violet-300 text-xs font-medium uppercase tracking-wider">
                Nombre de joueurs présents
            </p>

            <span class="block text-white text-4xl font-bold mt-2">
            {{ $this->count_player }}
        </span>
        </div>
    </div>
    <livewire:admin.team :playersWithStatus="$this->trains->players"></livewire:admin.team>

</div>
