<?php

use App\Livewire\Forms\CreateEventForm;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public CreateEventForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();

        $this->dispatch('match-created');
    }
};

?>

<div>

    @unless(Auth::user()->player)

        <x-drawer event="Création d'un match">

            <x-layout_forms
                title_form="Création d'un match"
                subtitle_form="Créer votre événement match"
                button="Connexion"
            >

                <form class="w-full" wire:submit.prevent="save">

                    <div class="sm:flex sm:flex-row sm:flex-wrap gap-5">

                        <x-form.input
                            label_name="Date"
                            for_label="date"
                            placeholder="Choissisez une date"
                            type="date"
                            id="date"
                            name="date"
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
                            label_name="Heure arrivé"
                            for_label="hours"
                            placeholder="Entrez l'heure d'arriver"
                            type="text"
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
                            label_name="Nom de l'équipe a domicile"
                            for_label="name_home"
                            placeholder="Entrez le nom de l'équipe a domicile"
                            type="text"
                            id="name_home"
                            name="name_home"
                            wire:model="form.name_home">

                            <div>
                                @error('form.name_home')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </x-form.input>

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
                            n
                        </x-form.input>

                    </div>

                    <div class="sm:flex sm:flex-row sm:flex-wrap gap-5">

                        <x-form.input
                            label_name="Photo de l'équipe a domicile"
                            for_label="photo_home"
                            placeholder=""
                            type="file"
                            id="photo_home"
                            name="photo_home"
                            wire:model="form.photo_home">

                            <div>
                                @error('form.photo_home')
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
    @endunless
    <div
        x-data="{ show: false }"

        x-on:match-created.window="
            show = true;

            setTimeout(() => {
                show = false
            }, 4000)

            document.dispatchEvent(
                new CustomEvent('close-drawer')
            )
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-5 right-5 z-[9999]"
        style="display: none;">

        <div class="bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl font-semibold">
            ✅ Match créé avec succès
        </div>

    </div>

</div>
