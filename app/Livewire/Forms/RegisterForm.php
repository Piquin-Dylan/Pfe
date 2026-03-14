<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Validate('required', message: 'Le champs prénom est requis')]
    #[Validate('min:3', message: 'Le prénom doit comporter minimum 3 caractères')]
    #[Validate('max:20', message: 'Le prénom doit comporter maximum 20 caractères')]
    public string $firstName = "";

    #[Validate('required', message: 'Le champs nom est requis')]
    #[Validate('min:3', message: 'Le nom doit comporter minimum 3 caractères')]
    #[Validate('max:20', message: 'Le nom doit comporter maximum 20 caractères')]
    public string $lastName = "";


    #[Validate('required', message: 'Le champs email est requis')]
    #[Validate('email', message: 'Veuillez entrer une adresse mail correcte')]
    public string $email = "";

    #[Validate('required', message: 'Le champs mot de passe est requis')]
    public string $password = "";


    public function save(): void
    {
        $this->validate();
    }
}
