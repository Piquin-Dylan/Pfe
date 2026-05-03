<?php

namespace App\Livewire\Forms;

use App\Models\Team;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateTeamForm extends Form
{

    use WithFileUploads;


    #[Validate('required', message: 'Le champs nom est requis')]
    public string $name = "";

    #[Validate('required', message: 'Le champs ville est requis')]
    #[Validate('max:30', message: 'La ville doit comporter maximum 30 caractères')]
    public string $ville = "";

    #[Validate('required', message: 'Le champs division est requis')]
    #[Validate('max:30', message: 'La vivision doit comporter maximum 30 caractères')]
    public string $division = "";

    #[Validate('required|image', message: 'Le champs logo  est requis')]
    public $logo = "";

    public string $message = "";

    public function submit(): void
    {
        $user = auth()->user()->getAuthIdentifier();
        $code = Str::password(16, true, true, false);
        $this->validate();

        $photoLogo = $this->logo->store('photos', 'public');

        Team::create([
            'user_id' => $user,
            'name' => $this->name,
            'ville' => $this->ville,
            'division' => $this->division,
            'code' => $code,
            'logo' => $photoLogo,
        ]);


    }
}
