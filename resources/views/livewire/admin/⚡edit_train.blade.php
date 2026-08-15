<?php

use App\Livewire\Forms\EditTrainForm;
use App\Models\Train;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {

    public EditTrainForm $form;

    #[On('open-edit-train-modal')]
    public function openModal($id): void
    {
        $train = Train::where('uuid', $id)->firstOrFail();

        $this->authorize('update', $train);

        $this->form->mount($train);
    }

    public function update(): void
    {
        $this->form->validate();
        $this->form->update();

        $this->dispatch('refresh-calendar');
        $this->dispatch('train-updated');
    }
};

?>

<div>
    @unless(Auth::user()->player)

        <x-drawer
            event="Modifier un entraînement"
            openEvent="open-edit-train-modal"
            :showButton="false"
        >
            <x-layout_forms
                title_form="Modifier un entraînement"
                subtitle_form="Modifier les informations de l'entraînement"
                containerClass="">
                <form class="w-full" wire:submit.prevent="update">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-form.input
                            label_name="Date"
                            for_label="edit_training_date"
                            placeholder="Choisissez une date"
                            type="date"
                            id="edit_training_date"
                            name="date"
                            wire:model.live="form.date">
                            <div>
                                @error('form.date')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </x-form.input>

                        <x-form.input
                            label_name="Lieu de l'entraînement"
                            for_label="edit_places"
                            placeholder="Entrez le lieu de l'entraînement"
                            type="text"
                            id="edit_places"
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
                            for_label="edit_hours_start"
                            type="time"
                            id="edit_hours_start"
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
                            for_label="edit_hours_end"
                            type="time"
                            id="edit_hours_end"
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
                        text="Enregistrer les modifications"
                        type="submit"
                        class="mt-6">
                    </x-form.button>
                </form>
            </x-layout_forms>
        </x-drawer>
    @endunless

    <div
        x-data="{ show: false }"

        x-on:train-updated.window="
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
            ✅ Entraînement modifié avec succès
        </div>

    </div>
</div>
