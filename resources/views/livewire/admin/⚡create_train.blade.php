<?php

use Livewire\Component;

new class extends Component {
    public \App\Livewire\Forms\CreateTrainForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();
        $this->dispatch('refresh-calendar');
        $this->dispatch('match-created');

    }
};
?>

<div>
    @unless(Auth::user()->player)

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
                    @if (session()->has('status'))
                        <div
                            x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 4000)"
                            x-show="show"
                            class="text-green-500 text-2xl p-4 mt-8 mb-4"
                        >
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-form.input
                            label_name="Date"
                            for_label="date"
                            placeholder="Choisissez une date"
                            type="date"
                            id="date"
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
                ✅ Entrainement créer avec succès
            </div>

        </div>
</div>
