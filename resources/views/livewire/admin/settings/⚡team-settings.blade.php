<?php


use App\Livewire\Forms\EditFormTeam;
use Livewire\Component;

new class extends Component {

    use \Livewire\WithFileUploads;

    public EditFormTeam $form;

    public function mount(): void
    {
        $this->form->mount();
    }

    public function updateTeam(): void
    {
        $this->form->update();

        session()->flash('success', 'Équipe mise à jour avec succès.');
    }
};
?>

<div>

    @if(session()->has('success'))
        <div class="p-4 rounded-xl bg-green-500/20 border border-green-500/30 text-green-400 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="updateTeam" class="space-y-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <x-form.input
                label_name="Nom de l'équipe"
                for_label="name"
                placeholder="Ex : Standard"
                type="text"
                id="name"
                name="name"
                wire:model.live="form.name">
            </x-form.input>

            <x-form.input
                label_name="Ville de l'équipe"
                for_label="ville"
                placeholder="Ex : Liège"
                type="text"
                id="ville"
                name="ville"
                wire:model.live="form.ville">
            </x-form.input>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <x-form.input
                label_name="Division de l'équipe"
                for_label="division"
                placeholder="Ex : D1"
                type="text"
                id="division"
                name="division"
                wire:model.live="form.division">
            </x-form.input>

            <x-form.input
                label_name="Logo du club"
                for_label="logo"
                type="file"
                id="logo"
                name="logo"
                wire:model.live="form.logo">
            </x-form.input>

        </div>

        @if($form->logo)
            <div class="flex justify-center">
                <img
                    src="{{ $form->logo->temporaryUrl() }}"
                    alt="Prévisualisation du logo"
                    class="w-24 h-24 rounded-full object-cover"
                >
            </div>
        @endif

        <div class="flex justify-center">
            <button
                type="submit"
                class="w-full text-white btn-primary">
                Modifier l'équipe
            </button>
        </div>

    </form>

</div>
