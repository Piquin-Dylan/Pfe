<?php

use App\Livewire\Forms\CompleteProfileForm;
use Livewire\Component;

new class extends Component {

    public CompleteProfileForm $form;


    public function save(): void
    {
        $this->form->submit();
    }
};
?>

<div>
    <section>
        <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
            <form wire:submit.prevent="save">
                <div class="sm:flex sm:flex-row sm:flex-wrap ">
                    <x-form.input
                        label_name="Nom de famille"
                        for_label="name"
                        placeholder=""
                        type="text"
                        id="name"
                        name="name"
                        wire:model.live="form.name" required>
                        <div>
                            @error('form.name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                        label_name="Prénom"
                        for_label="firstName"
                        placeholder="Dupont"
                        type="text"
                        id="firstName"
                        name="firstName"
                        wire:model.live="form.firstName" required>
                        <div>
                            @error('form.firstName') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                        label_name="Poste sur le terrain"
                        for_label="poste"
                        placeholder=""
                        type="text"
                        id="poste"
                        name="poste"
                        wire:model.live="form.poste" required>
                        <div>
                            @error('form.poste') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                        label_name="Numéros de maillot"
                        for_label="maillot"
                        placeholder=""
                        type="text"
                        id="maillot"
                        name="maillot"
                        wire:model.live="form.maillot" required>
                        <div>
                            @error('form.maillot') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                </div>
                <div class="flex justify-center">
                    <button class="text-white" type="submit">Compléter mon profile</button>
                </div>
            </form>

        </div>
    </section>
