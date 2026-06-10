<?php

use App\Livewire\Forms\EditFormProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public EditFormProfile $form;

    public function mount(): void
    {
        $this->form->mount();
    }

    public function updateProfile(): void
    {
        $this->form->update();

        session()->flash('success', 'Profil mis à jour avec succès.');
    }
};
?>

<div>
    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-green-500/20 border border-green-500/30 text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="updateProfile" class="space-y-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <x-form.input
                label_name="Prénom"
                for_label="firstName"
                placeholder="Jean"
                type="text"
                id="firstName"
                name="firstName"
                wire:model="form.firstName">
            </x-form.input>

            <x-form.input
                label_name="Nom"
                for_label="lastName"
                placeholder="Dupont"
                type="text"
                id="lastName"
                name="lastName"
                wire:model="form.lastName">
            </x-form.input>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <x-form.input
                label_name="Email"
                for_label="email"
                placeholder="jean.dupont@gmail.com"
                type="email"
                id="email"
                name="email"
                wire:model="form.email">
            </x-form.input>

            <x-form.input
                label_name="Photo de profil"
                for_label="photo"
                type="file"
                id="photo"
                name="photo"
                wire:model="form.image">
            </x-form.input>

        </div>

        @if($form->image)
            <div class="flex justify-center">
                <img
                    src="{{ $form->image->temporaryUrl() }}"
                    alt="Prévisualisation"
                    class="w-24 h-24 rounded-full object-cover">
            </div>
        @endif
        <div class="flex justify-center">
            <button
                type="submit"
                class="w-full text-white btn-primary">
                Modifier
            </button>
        </div>
    </form>
</div>
