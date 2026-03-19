<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required', message: 'Le champs email est requis')]
    #[Validate('email', message: 'Veuillez entrer une adresse mail correcte')]
    public string $email = "";

    #[Validate('required', message: 'Le champs mot de passe est requis')]
    public string $password = "";


    public function submit(): void
    {
        $this->validate();

    }
}
