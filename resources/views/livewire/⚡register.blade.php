<?php

use App\Livewire\Forms\RegisterForm;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    public RegisterForm $form;

    public function save(): void
    {
        $this->form->submit();
    }

};
?>
<?php dd(auth()->user()->getAuthIdentifier()); ?>

<section>
    <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
        <form wire:submit.prevent="save">
            <div class="sm:flex sm:flex-row sm:flex-wrap ">
                <x-form.input
                    label_name="Prénom"
                    for_label="firstName"
                    placeholder="Jean"
                    type="text"
                    id="firstName"
                    name="firstName"
                    wire:model.live="form.firstName">
                    <div>
                        @error('form.firstName') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-form.input>
                <x-form.input
                    label_name="Nom de famille"
                    for_label="lastName"
                    placeholder="Dupont"
                    type="text"
                    id="lastName"
                    name="lastName"
                    wire:model.live="form.lastName">
                    <div>
                        @error('form.lastName') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-form.input>
                <x-form.input
                    label_name="Adress email"
                    for_label="email"
                    placeholder="Ex : jean.dupont@gmail.com"
                    type="email"
                    id="email"
                    name="email"
                    wire:model.live="form.email">
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
                    wire:model.live="form.password">
                    <div>
                        @error('form.password') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-form.input>


            </div>
            <div class="flex justify-center">
                <button class="text-white" type="submit">Inscription</button>
            </div>
        </form>

    </div>
</section>

