<?php

use App\Livewire\Forms\RegisterForm;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

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
<section class="pt-20 lg:pt-8">
    <h2 class="sr-only">Formulaire - Inscription</h2>
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
                    wire:model="form.firstName">
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
                    wire:model="form.lastName">
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
                    wire:model="form.email">
                    <div>
                        @error('form.email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>

                <x-form.input
                    label_name="Mot de passe"
                    for_label="password"
                    type="password"
                    id="password"
                    name="password"
                    wire:model="form.password">
                    <div>
                        @error('form.password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>
            </div>
            <div>

                <x-form.input
                    label_name="Photo de profile"
                    for_label="photo"
                    placeholder=""
                    type="file"
                    id="photo"
                    name="photo"
                    wire:model="form.image">
                    <div>
                        @error('form.image')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </x-form.input>
                @if($form->image)
                    <img src="{{ $form->image->temporaryUrl() }}" alt="">
                @endif
                {{-- <input type="file"
                        class="input-dark file:bg-transparent file:text-white file:border-none w-full"
                        wire:model="form.image">

                 @error('form.image')
                 <span class="error">{{ $message }}</span>
                 @enderror--}}
            </div>

            <div class="flex justify-center items-center">
                <button type="submit"
                        class="w-full text-white btn-primary">
                    Inscription
                </button>
            </div>

        </form>

    </x-layout_forms>

</section>
