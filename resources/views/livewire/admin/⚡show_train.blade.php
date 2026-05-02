<?php

use App\Models\Train;
use Livewire\Component;

new class extends Component {

    public Train $trains;
    public function mount($id): void
    {
       $this->trains = Train::findOrFail($id);

        $this->trains->players()->get();

dump($this->trains->players);
    }
};
?>

<div>
    <div class="text-white text-2xl">Joueur présent a l'entrainement du {{\Carbon\Carbon::parse($trains->date_train)->locale('fr')->translatedFormat('d F')}}</div>
    <livewire:admin.team :playersWithStatus="$this->trains->players"></livewire:admin.team>
</div>
