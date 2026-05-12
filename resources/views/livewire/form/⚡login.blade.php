<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    public LoginForm $form;

    public function save()
    {
        $this->form->submit();

        if (Auth::attempt(["email" => $this->form->email, "password" => $this->form->password
        ])) {
            return $this->redirect('/hub');
        } else {

            session()->flash('status', "Le mot de passe ou l'adresse email est incorrect");
        }

    }

}
?>

<section>

    <x-layout_forms title_form="Connexion" subtitle_form="Connectez-vous pour accéder à votre hub" button="Connexion"
                    text="Vous n'avez pas encore de compte ?"
                    action="Inscription" redirection="inscription">

        @if  (session()->has('status'))
            <div
                x-data="{ show: true }"
                x-show="show"
                class=" text-red-500 text-center text-xl p-4 mt-8 mb-4">
                {{ session('status') }}
            </div>
        @endif
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
            <x-form.input
                label_name="Mot de passe"
                for_label="password"
                placeholder=""
                type="password"
                id="password"
                name="password"
                wire:model="form.password">

                <div>
                    @error('form.password') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
            <button type="submit"
                    class="w-full text-white py-3 rounded-xl font-semibold bg-gradient-to-r from-purple-500 to-indigo-500 hover:scale-[1.02] transition duration-200 shadow-lg shadow-purple-500/30 mt-3">
                Connexion
            </button>
        </form>
    </x-layout_forms>

</section>
