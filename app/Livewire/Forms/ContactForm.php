<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    #[Validate('required')]
    public string $name = '';

    #[Validate('required')]
    public string $email = "";

    #[Validate('required')]
    public string $subject = "";

    #[Validate('required')]
    public string $message = "";


    public function submit(): void
    {
        $this->validate();

        dd($this->email);

    }
}
