<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email:rfc|max:255')]
    public string $email = "";

    #[Validate('required|string|max:255')]
    public string $subject = "";

    #[Validate('required|string|max:5000')]
    public string $message = "";
}
