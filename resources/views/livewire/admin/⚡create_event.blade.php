<?php

use App\Livewire\Forms\CreateEventForm;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public CreateEventForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();

        $this->dispatch('refresh-calendar');
        $this->dispatch('notify', message: 'Match créé avec succès.', type: 'success');
        $this->dispatch('close-drawer');
    }

    #[On('open-create-game-modal')]
    public function openModal($date = null): void
    {
        $this->form->date = $date;

        $this->dispatch('open-drawer');
    }
};

?>

<div>

    @can('manage-team')

        <x-drawer
            event="Création d'un match"
            openEvent="open-create-game-modal"
        >

            <x-layout_forms
                title_form="Création d'un match"
                subtitle_form="Créer votre événement match"
                button="Connexion"
                containerClass=""
            >
                <form class="w-full" wire:submit.prevent="save">

                    <div class="sm:flex sm:flex-row sm:flex-wrap gap-5">

                        <x-form.input
                            label_name="Date"
                            for_label="match_date"
                            placeholder="Choisissez une date"
                            type="date"
                            id="match_date"
                            name="date"
                            min="{{ now()->format('Y-m-d') }}"
                            wire:model="form.date">

                            <div>
                                @error('form.date')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </x-form.input>

                        <x-form.input
                            label_name="Lieux du match"
                            for_label="place"
                            placeholder="Entrez le lieux du match"
                            type="text"
                            id="place"
                            name="place"
                            wire:model="form.place">

                            <div>
                                @error('form.place')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </x-form.input>

                    </div>

                    <div class="sm:flex sm:flex-row sm:flex-wrap">

                        <x-form.input
                            label_name="Heure du match"
                            for_label="hours"
                            placeholder="Entrez l'heure du match"
                            type="time"
                            id="hours"
                            name="hours"
                            wire:model="form.hours">

                            <div>
                                @error('form.hours')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </x-form.input>

                    </div>


                    <div class="sm:flex sm:flex-row sm:flex-wrap gap-5">
                        <x-form.input
                            label_name="Nom de l'équipe a l'extérieur"
                            for_label="name_away"
                            placeholder="Entrez le nom de l'équipe a l'extérieur"
                            type="text"
                            id="name_away"
                            name="name_away"
                            wire:model.live="form.name_away">

                            <div>
                                @error('form.name_away')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </x-form.input>

                        <x-form.input label_name="Photo de l'équipe a l'extérieur"
                                      for_label="photo_away"
                                      placeholder=""
                                      type="file"
                                      id="photo_away"
                                      name="photo_away"
                                      wire:model="form.photo_away">

                            <div>
                                @error('form.photo_away')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>
                    </div>
                    <x-form.button class="btn-primary" text="Création du match" type="submit">Créer match
                    </x-form.button>
                </form>
            </x-layout_forms>
        </x-drawer>
    @endcan

</div>
