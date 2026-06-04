<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class EditFormProfile extends Form
{
    use WithFileUploads;

    #[Validate('required', message: 'Le champ prénom est requis')]
    #[Validate('min:3', message: 'Le prénom doit comporter minimum 3 caractères')]
    #[Validate('max:20', message: 'Le prénom doit comporter maximum 20 caractères')]
    public string $firstName = '';

    #[Validate('required', message: 'Le champ nom est requis')]
    #[Validate('min:3', message: 'Le nom doit comporter minimum 3 caractères')]
    #[Validate('max:20', message: 'Le nom doit comporter maximum 20 caractères')]
    public string $lastName = '';

    #[Validate('required', message: 'Le champ email est requis')]
    #[Validate('email', message: 'Veuillez entrer une adresse mail correcte')]
    public string $email = '';

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    public function mount(): void
    {
        $this->firstName = Auth::user()->firstName;
        $this->lastName = Auth::user()->lastName;
        $this->email = Auth::user()->email;
    }

    public function update(): void
    {
        $this->validate();

        validator(
            ['email' => $this->email],
            [
                'email' => [
                    Rule::unique('users', 'email')->ignore(Auth::id()),
                ],
            ],
            [
                'email.unique' => 'Cette adresse mail existe déjà.',
            ]
        )->validate();

        $data = [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('photos', 'public');
        }

        Auth::user()->update($data);

        $this->reset('image');
    }
}
