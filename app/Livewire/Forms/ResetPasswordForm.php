<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ResetPasswordForm extends Form
{
    public string $token = "";

    #[Validate('required', message: 'Le champs email est requis')]
    #[Validate('email', message: 'Veuillez entrer une adresse mail correcte')]
    public string $email = "";

    #[Validate('required', message: 'Le champs mot de passe est requis')]
    #[Validate('min:8', message: 'Le mot de passe doit contenir au moins 8 caractères')]
    public string $password = "";

    #[Validate('required', message: 'Veuillez confirmer le mot de passe')]
    #[Validate('same:password', message: 'Les mots de passe ne correspondent pas')]
    public string $password_confirmation = "";

    public function submit(): void
    {
        $this->validate();
    }
}
