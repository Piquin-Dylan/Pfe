<?php

use App\Livewire\Forms\EditEventForm;
use App\Models\Game;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public EditEventForm $form;

    #[On('open-edit-game-modal')]
    public function openModal($id): void
    {
        $game = Game::where('uuid', $id)->firstOrFail();

        $this->authorize('update', $game);

        $this->form->mount($game);
    }

    public function update(): void
    {
        $this->form->validate();
        $this->form->update();

        $this->dispatch('refresh-calendar');
        $this->dispatch('match-updated');
        $this->dispatch('close-drawer');
    }
};

?>

<div>

    @can('manage-team')

        <x-drawer
            event="Modifier un match"
            openEvent="open-edit-game-modal"
            :showButton="false"
        >

            <x-layout_forms
                title_form="Modifier un match"
                subtitle_form="Modifier les informations de l'événement"
                containerClass=""
            >
                <form class="w-full" wire:submit.prevent="update">

                    <div class="sm:flex sm:flex-row sm:flex-wrap gap-5">

                        <x-form.input
                            label_name="Date"
                            for_label="edit_match_date"
                            placeholder="Choisissez une date"
                            type="date"
                            id="edit_match_date"
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
                            for_label="edit_place"
                            placeholder="Entrez le lieux du match"
                            type="text"
                            id="edit_place"
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
                            for_label="edit_hours"
                            placeholder="Entrez l'heure du match"
                            type="time"
                            id="edit_hours"
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
                            for_label="edit_name_away"
                            placeholder="Entrez le nom de l'équipe a l'extérieur"
                            type="text"
                            id="edit_name_away"
                            name="name_away"
                            wire:model.live="form.name_away">

                            <div>
                                @error('form.name_away')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </x-form.input>

                        <x-form.input label_name="Nouvelle photo de l'équipe a l'extérieur (optionnel)"
                                      for_label="edit_photo_away"
                                      placeholder=""
                                      type="file"
                                      id="edit_photo_away"
                                      name="photo_away"
                                      wire:model="form.photo_away">

                            <div>
                                @error('form.photo_away')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>
                    </div>
                    <x-form.button class="btn-primary" text="Enregistrer les modifications" type="submit">
                    </x-form.button>
                </form>
            </x-layout_forms>
        </x-drawer>
    @endcan

    <div
        x-data="{ show: false }"

        x-on:match-updated.window="
            show = true;

            setTimeout(() => {
                show = false
            }, 4000)
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
            ✅ Match modifié avec succès
        </div>

    </div>

</div>
