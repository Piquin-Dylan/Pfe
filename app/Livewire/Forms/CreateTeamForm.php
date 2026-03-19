<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateTeamForm extends Form
{

    #[Validate('required', message: 'Le champs nom est requis')]
    public string $name = "";

    #[Validate('required', message: 'Le champs ville est requis')]
    #[Validate('max:30', message: 'La ville doit comporter maximum 30 caractères')]
    public string $ville = "";

    #[Validate('required', message: 'Le champs division est requis')]
    #[Validate('max:30', message: 'La vivision doit comporter maximum 30 caractères')]
    public string $division = "";

    #[Validate('required', message: 'Le champs logo  est requis')]
    public $logo;

    public string $message = "";


    public function submit(): void
    {
        $this->validate();
    }
}
