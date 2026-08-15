<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class EditEventForm extends Form
{
    use WithFileUploads;

    public ?Game $game = null;

    #[Validate('required', message: 'Le champs date est requis')]
    public string $date = "";

    #[Validate('required', message: 'Le champs lieux est requis')]
    public string $place = "";

    #[Validate('required', message: 'Le champs heure de convocation est requis')]
    public string $hours = "";

    #[Validate('required', message: "Le champs nom équipe a l'extérieur est requis")]
    public string $name_away = "";

    #[Validate('nullable|image|max:2048')]
    public $photo_away = null;

    public function mount(Game $game): void
    {
        $this->game = $game;
        $this->date = $game->date_match;
        $this->place = $game->address;
        $this->hours = $game->hours;
        $this->name_away = $game->name_away;
        $this->photo_away = null;
    }

    public function update(): void
    {
        $this->validate();

        $data = [
            'date_match' => $this->date,
            'address' => $this->place,
            'hours' => $this->hours,
            'name_away' => $this->name_away,
        ];

        if ($this->photo_away) {
            $data['photo_away'] = $this->photo_away->store('photos', 'public');
        }

        $this->game->update($data);

        $this->reset('photo_away');
    }
}
