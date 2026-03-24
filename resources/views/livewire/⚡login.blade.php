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
        }
        return $this->redirect('/');
    }

}
?>

<section>

    <div class=" pt-12 lg:pr-[150px]  lg:pl-[150px]">
        <x-title_subtitle_form title="Connexion"
                               subtitle="Connectez-vous pour accéder à votre équipe de football."></x-title_subtitle_form>
        <form wire:submit="save">
            <div class="sm:flex sm:flex-row sm:flex-wrap ">
                <x-form.input
                        label_name="Adress email"
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


            </div>
            <div class="flex justify-center gap-2 items-center flex-col">
                <x-form.button type="submit" text="Connexion"></x-form.button>
                <span class="  text-white  flex justify-center">Pas encore de compte ?<a class="font-bold" href="/connexion">  Créer un compte</a> </span>
            </div>
        </form>

    </div>
</section>
