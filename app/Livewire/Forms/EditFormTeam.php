<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class EditFormTeam extends Form
{
    use WithFileUploads;

    #[Validate('required', message: 'Le champ nom est requis')]
    public string $name = '';

    #[Validate('required', message: 'Le champ ville est requis')]
    #[Validate('max:30', message: 'La ville doit comporter maximum 30 caractères')]
    public string $ville = '';

    #[Validate('required', message: 'Le champ division est requis')]
    #[Validate('max:30', message: 'La division doit comporter maximum 30 caractères')]
    public string $division = '';

    #[Validate('nullable|image|max:2048')]
    public $logo = null;

    public function mount(): void
    {
        $team = Auth::user()->team;

        $this->name = $team->name;
        $this->ville = $team->ville;
        $this->division = $team->division;
    }

    public function update(): void
    {
        $this->validate();

        $team = Auth::user()->team;

        $data = [
            'name' => $this->name,
            'ville' => $this->ville,
            'division' => $this->division,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('photos', 'public');
        }

        $team->update($data);

        $this->reset('logo');
    }
}
