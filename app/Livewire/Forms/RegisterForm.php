<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

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
    #[Validate('unique:users', message: 'Cette adresse mail existe déjà.')]
    public string $email = "";

    #[Validate('required', message: 'Le champs mot de passe est requis')]
    public string $password = "";


    public  $image;


    public function submit(): void
    {
        $this->validate();

        $path = $this->image->store(path: 'photos');
        User::create([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => Hash::make($this->password, [
                'rounds' => "12",

            ]),
            'image' => $path,
        ]);


        $this->reset(['firstName', 'lastName', 'email', 'password', 'image']);
    }


}
