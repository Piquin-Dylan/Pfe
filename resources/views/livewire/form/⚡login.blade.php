<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    public LoginForm $form;

    public function save()
    {
        $this->form->submit();

        if ($this->tooManyLoginAttempts()) {
            $seconds = RateLimiter::availableIn($this->throttleKey());

            session()->flash('error', "Trop de tentatives de connexion. Réessayez dans {$seconds} secondes.");

            return;
        }

        if (Auth::attempt(["email" => $this->form->email, "password" => $this->form->password
        ])) {
            RateLimiter::clear($this->throttleKey());

            return $this->redirect('/hub');
        } else {

            RateLimiter::hit($this->throttleKey(), 60);

            session()->flash('error', "Le mot de passe ou l'adresse email est incorrect");
        }

    }

    protected function tooManyLoginAttempts(): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 5);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->form->email) . '|' . request()->ip());
    }

}
?>

<section>
    <h2 class="sr-only">Formulaire - Connexion</h2>
    <x-layout_forms title_form="Connexion" subtitle_form="Connectez-vous pour accéder à votre hub" button="Connexion"
                    text="Vous n'avez pas encore de compte ?"
                    action="Inscription" redirection="register">

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
                type="password"
                id="password"
                name="password"
                wire:model="form.password">

                <div>
                    @error('form.password') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
            <div class="text-right -mt-2 mb-4">
                <a href="/forgot-password" class="text-purple-400 text-sm hover:underline">
                    Mot de passe oublié ?
                </a>
            </div>
            <div class="flex justify-center items-center">

            <button type="submit"
                    class="w-full text-white btn-primary ">
                Connexion
            </button>
            </div>
        </form>
    </x-layout_forms>

</section>
