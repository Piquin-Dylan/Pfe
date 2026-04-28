<?php

use Livewire\Component;

new class extends Component {
    public \App\Livewire\Forms\CreateTrainForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();
        session()->flash('status', 'Le match a été créer avec succès');

    }
};
?>

<div>
    <form class="w-full" wire:submit.prevent="save">
        @if (session()->has('status'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                class=" text-green-500 text-2xl p-4 mt-8 mb-4">
                {{ session('status') }}
            </div>
        @endif
        <div class="sm:flex sm:flex-row sm:flex-wrap ">
            <x-form.input
                label_name="Date"
                for_label="date"
                placeholder="Choissisez une date"
                type="date"
                id="date"
                name="date"
                wire:model.live="form.date">
                <div>
                    @error('form.date') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
            <x-form.input
                label_name="Lieux du match"
                for_label="places"
                placeholder="Entrez le lieux du match"
                type="text"
                id="places"
                name="places"
                wire:model.live="form.places">
                <div>
                    @error('form.places') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
        </div>
        <div class="sm:flex sm:flex-row sm:flex-wrap ">
            <x-form.input
                label_name="Heure de début de l'entrainement"
                for_label="hours_start"
                placeholder="Entrez l'heure du début de l'entrainement"
                type="time"
                id="hours_start"
                name="hours_start"
                wire:model.live="form.hours_start">
                <div>
                    @error('form.hours_start') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
        </div>
        <div class="sm:flex sm:flex-row sm:flex-wrap ">
            <x-form.input
                label_name="Heure de fin de l'entrainement"
                for_label="hours_end"
                placeholder="Entrez l'heure de fin"
                type="time"
                id="hours_end"
                name="hours_end"
                wire:model.live="form.hours_end">
                <div>
                    @error('form.hours_end') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>

        </div>
        <x-form.button text="Création du match" type="submit">Créer un entrainement</x-form.button>

    </form>
</div>
