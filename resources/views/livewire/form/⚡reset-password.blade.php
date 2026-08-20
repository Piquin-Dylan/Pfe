<?php

use App\Livewire\Forms\ResetPasswordForm;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

new class extends Component {

    public ResetPasswordForm $form;

    public function mount(string $token, string $email = '')
    {
        $this->form->token = $token;
        $this->form->email = $email;
    }

    public function save()
    {
        $this->form->submit();

        $status = Password::reset(
            [
                'email' => $this->form->email,
                'password' => $this->form->password,
                'password_confirmation' => $this->form->password_confirmation,
                'token' => $this->form->token,
            ],
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->form->password, ['rounds' => 12]),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Votre mot de passe a été réinitialisé avec succès, vous pouvez vous connecter.');
            return $this->redirect('/login');
        }

        session()->flash('status', "Ce lien de réinitialisation est invalide ou a expiré.");
    }

}
?>

<section>
    <h2 class="sr-only">Formulaire - Réinitialisation du mot de passe</h2>
    <x-layout_forms title_form="Nouveau mot de passe" subtitle_form="Choisissez un nouveau mot de passe" button="Réinitialiser"
                    text="Vous vous souvenez de votre mot de passe ?"
                    action="Connexion" redirection="login">

        @if (session()->has('status'))
            <div
                x-data="{ show: true }"
                x-show="show"
                class="text-red-500 text-center text-xl p-4 mt-8 mb-4">
                {{ session('status') }}
            </div>
        @endif
        <form wire:submit.prevent="save">
            <x-form.input
                label_name="Adresse mail"
                for_label="email"
                type="email"
                id="email"
                name="email"
                wire:model="form.email">
                <div>
                    @error('form.email') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>

            <x-form.input
                label_name="Nouveau mot de passe"
                for_label="password"
                type="password"
                id="password"
                name="password"
                wire:model="form.password">
                <div>
                    @error('form.password') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>

            <x-form.input
                label_name="Confirmez le mot de passe"
                for_label="password_confirmation"
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                wire:model="form.password_confirmation">
                <div>
                    @error('form.password_confirmation') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>

            <div class="flex justify-center items-center">
                <button type="submit"
                        class="w-full text-white btn-primary">
                    Réinitialiser le mot de passe
                </button>
            </div>
        </form>
    </x-layout_forms>

</section>
