<?php

use Livewire\Component;

new class extends Component {
    public \App\Livewire\Forms\CreateTrainForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();
        $this->dispatch('refresh-calendar');
        $this->dispatch('notify', message: 'Entrainement créé avec succès.', type: 'success');
        $this->dispatch('close-drawer');

    }
};
?>

<div>
    @can('manage-team')

        <x-drawer
            event="Création d'un entraînement"
            openEvent="open-create-train-modal"
        >
            <x-layout_forms
                title_form="Création d'un entrainement"
                subtitle_form="Créer votre première entrainement"
                button="Connexion"
                containerClass="">
                <form class="w-full" wire:submit.prevent="save">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-form.input
                            label_name="Date"
                            for_label="training_date"
                            placeholder="Choisissez une date"
                            type="date"
                            id="training_date"
                            name="date"
                            min="{{ now()->format('Y-m-d') }}"
                            wire:model.live="form.date">
                            <div>
                                @error('form.date')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>

                        <x-form.input
                            label_name="Lieu de l'entraînement"
                            for_label="places"
                            placeholder="Entrez le lieu de l'entraînement"
                            type="text"
                            id="places"
                            name="places"
                            wire:model.live="form.places">
                            <div>
                                @error('form.places')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>

                        <x-form.input
                            label_name="Heure de début de l'entraînement"
                            for_label="hours_start"
                            type="time"
                            id="hours_start"
                            name="hours_start"
                            wire:model.live="form.hours_start">
                            <div>
                                @error('form.hours_start')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>

                        <x-form.input
                            label_name="Heure de fin de l'entraînement"
                            for_label="hours_end"
                            type="time"
                            id="hours_end"
                            name="hours_end"
                            wire:model.live="form.hours_end">
                            <div>
                                @error('form.hours_end')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>
                    </div>

                    <x-form.button
                        text="Création de l'entraînement"
                        type="submit"
                        class="mt-6">
                        Créer un entraînement
                    </x-form.button>
                </form>
            </x-layout_forms>
        </x-drawer>
    @endcan
</div>
