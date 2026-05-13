<?php

use App\Livewire\Forms\RegisterForm;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

new class extends Component {
    use WithFileUploads;


    public RegisterForm $form;

    public function save(): void
    {
        $this->form->submit();


        $this->redirect('/hub');
    }

};
?>
<section>

    <x-layout_forms
        title_form="Inscription"
        subtitle_form="Inscrivez vous pour créer votre équipe de football"
        text="Vous avez déjà un compte ?"
        action="Connexion"
        redirection="login">

        <form wire:submit.prevent="save" class="space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <x-form.input
                    label_name="Prénom"
                    for_label="firstName"
                    placeholder="Jean"
                    type="text"
                    id="firstName"
                    name="firstName"
                    wire:model.live="form.firstName">
                    <div>
                        @error('form.firstName')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>

                <x-form.input
                    label_name="Nom"
                    for_label="lastName"
                    placeholder="Dupont"
                    type="text"
                    id="lastName"
                    name="lastName"
                    wire:model.live="form.lastName">
                    <div>
                        @error('form.lastName')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>

            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <x-form.input
                    label_name="Adresse email"
                    for_label="email"
                    placeholder="jean.dupont@gmail.com"
                    type="email"
                    id="email"
                    name="email"
                    wire:model.live="form.email">
                    <div>
                        @error('form.email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>

                <x-form.input
                    label_name="Mot de passe"
                    for_label="password"
                    placeholder=""
                    type="password"
                    id="password"
                    name="password"
                    wire:model.live="form.password">
                    <div>
                        @error('form.password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>
            </div>
            <div>
                <input type="file"
                       class="input-dark file:bg-transparent file:text-white file:border-none w-full"
                       wire:model.live="form.image">

                @error('form.image')
                <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    class="w-full text-white btn-primary">
                Inscription
            </button>

        </form>

    </x-layout_forms>

</section>
