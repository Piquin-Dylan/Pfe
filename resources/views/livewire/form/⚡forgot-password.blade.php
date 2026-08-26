<?php

use App\Livewire\Forms\ForgotPasswordForm;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

new class extends Component {

    public ForgotPasswordForm $form;

    public function save()
    {
        $this->form->submit();

        Password::sendResetLink(['email' => $this->form->email]);

        session()->flash('success', "Si cette adresse existe dans nos systèmes, un email de réinitialisation vient d'être envoyé.");
        $this->form->reset('email');
    }

}
?>

<section>
    <h2 class="sr-only">Formulaire - Mot de passe oublié</h2>
    <x-layout_forms title_form="Mot de passe oublié" subtitle_form="Recevez un lien pour réinitialiser votre mot de passe" button="Envoyer"
                    text="Vous vous souvenez de votre mot de passe ?"
                    action="Connexion" redirection="login">

        <form wire:submit.prevent="save">
            <x-form.input
                label_name="Adresse mail"
                for_label="email"
                placeholder="Ex : jean.dupont@gmail.com"
                type="email"
                id="email"
                name="email"
                wire:model="form.email">
                <div>
                    @error('form.email') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>

            <div class="flex justify-center items-center">
                <button type="submit"
                        class="w-full text-white btn-primary !max-w-full whitespace-nowrap">
                    Envoyer le lien
                </button>
            </div>
        </form>
    </x-layout_forms>

</section>
