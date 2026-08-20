<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ForgotPasswordForm extends Form
{
    #[Validate('required', message: 'Le champs email est requis')]
    #[Validate('email', message: 'Veuillez entrer une adresse mail correcte')]
    public string $email = "";

    public function submit(): void
    {
        $this->validate();
    }
}
