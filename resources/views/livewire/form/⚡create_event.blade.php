<?php

use App\Livewire\Forms\CreateEventForm;
use Livewire\Component;

new class extends Component {
    public CreateEventForm $form;

    public function save(): void
    {
        $this->form->validate();
    }
};
?>

<div>
    <div x-data="{ currentTab : 'first' }">

        <div class="flex gap-5 justify-center pt-6 pb-16">
            <button class="btn-primary" @click="currentTab = 'first'">Entrainement</button>
            <button class="btn-secondary" @click="currentTab = 'second' ">Match</button>
        </div>
        <div x-show=" currentTab === 'first' " class="flex flex-col gap-20 lg:flex-row ">
            <form action="">
                <label for="">Coach</label>
                <input type="text">
            </form>
        </div>

        <div x-show=" currentTab === 'second' " class="flex flex-col g-5 items-center">


        </div>

    </div>
    <form wire:submit.prevent="save">
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
                for_label="hours_first"
                placeholder="Entrez l'heure d'arriver"
                type="text"
                id="hours_first"
                name="hours_first"
                wire:model.live="form.hours_first">
                <div>
                    @error('form.hours_first') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
            <x-form.input
                label_name="Heure début du match"
                for_label="hours_second"
                placeholder="Entrez l'heure du match"
                type="text"
                id="hours_second"
                name="hours_second"
                wire:model.live="form.hours_second">
                <div>
                    @error('form.hours_second') <span class="error">{{ $message }}</span> @enderror
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
                label_name="Heure début du match"
                for_label="hours_second"
                placeholder="Entrez l'heure du match"
                type="text"
                id="hours_second"
                name="hours_second"
                wire:model.live="form.hours_second">
                <div>
                    @error('form.hours_second') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
        </div>
        <x-form.button text="Création du match" type="submit"></x-form.button>

    </form>
</div>
