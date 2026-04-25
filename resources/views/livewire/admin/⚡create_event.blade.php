<?php

use App\Livewire\Forms\CreateEventForm;
use Livewire\Component;

new class extends Component {
    public CreateEventForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();


    }
};
?>

<div>

    <x-drawer>
    <form class="w-full" wire:submit.prevent="save">
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
                for_label="place"
                placeholder="Entrez le lieux du match"
                type="text"
                id="place"
                name="place"
                wire:model.live="form.place">
                <div>
                    @error('form.place') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
        </div>
        <div class="sm:flex sm:flex-row sm:flex-wrap ">
            <x-form.input
                label_name="Heure arrivé"
                for_label="hours"
                placeholder="Entrez l'heure d'arriver"
                type="text"
                id="hours"
                name="hours"
                wire:model.live="form.hours">
                <div>
                    @error('form.hours') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
        </div>
        <div class="sm:flex sm:flex-row sm:flex-wrap ">
            <x-form.input
                label_name="Nom de l'équipe a domicile"
                for_label="name_home"
                placeholder="Entrez le nom de l'équipe a domicile"
                type="text"
                id="name_home"
                name="name_home"
                wire:model.live="form.name_home">
                <div>
                    @error('form.hours_first') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
            <x-form.input
                label_name="Nom de l'équipe a l'extérieur"
                for_label="name_away"
                placeholder="Entrez l'heure du match"
                type="text"
                id="name_away"
                name="name_away"
                wire:model.live="form.name_away">
                <div>
                    @error('form.name_away') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
        </div>
        <x-form.button text="Création du match" type="submit">Créer match</x-form.button>

    </form>
    </x-drawer>

</div>
