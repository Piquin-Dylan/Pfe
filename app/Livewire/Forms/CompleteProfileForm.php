<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CompleteProfileForm extends Form
{
    #[Validate('required', message: 'Le champs nom de famille est requis')]
    public string $name = "";

    #[Validate('required', message: 'Le champs prénom est requis')]
    public string $firstName = "";

    #[Validate('required', message: 'Le champs poste est requis')]
    public string $poste = "";

    #[Validate('required', message: 'Le champs numéros de maillot est requis')]
    #[Validate('int', message: 'Veuillez mettre un numéros de maillot correct')]
    public string $maillot = "";

    #[Validate('required', message: 'Le champs code est requis')]
    public string $code = "";


    public function submit(): void
    {

        $this->validate();
    }
}
