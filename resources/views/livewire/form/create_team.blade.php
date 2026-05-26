<?php

use App\Livewire\Forms\CreateTeamForm;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public CreateTeamForm $form;

    public function save(): void
    {
        $this->form->validate();
        $this->form->submit();

        $this->redirect('/hub');
    }
};

?>
<section>
    <h2 class="sr-only">Formulaire - Créer votre équipe</h2>

    <x-layout_forms
        title_form="Créer votre équipe"
        subtitle_form="Lancez-vous et créez votre première équipe de football !"
        text="Vous voulez rejoindre une équipe ?"
        action="Rejoindre une équipe"
        redirection="profile">

        <form wire:submit.prevent="save" class="space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <x-form.input
                    label_name="Nom de l'équipe"
                    for_label="name"
                    placeholder="Ex : Standard"
                    type="text"
                    id="name"
                    name="name"
                    wire:model.live="form.name">

                    @error('form.name')
                    <span class="error">{{ $message }}</span>
                    @enderror

                </x-form.input>

                <x-form.input
                    label_name="Ville de l'équipe"
                    for_label="ville"
                    placeholder="Ex : Liège"
                    type="text"
                    id="ville"
                    name="ville"
                    wire:model.live="form.ville">

                    @error('form.ville')
                    <span class="error">{{ $message }}</span>
                    @enderror

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

                    @error('form.division')
                    <span class="error">{{ $message }}</span>
                    @enderror

                </x-form.input>

                <x-form.input
                    label_name="Logo du club"
                    for_label="logo"
                    placeholder=""
                    type="file"
                    id="logo"
                    name="logo"
                    wire:model.live="form.logo">

                    @error('form.logo')
                    <span class="error">{{ $message }}</span>
                    @enderror

                </x-form.input>
                @if($form->logo)
                    <img src="{{ $form->logo->temporaryUrl() }}" alt="">
                @endif

            </div>

            <div class="flex justify-center items-center">

                <button type="submit"
                        class="w-full text-white btn-primary">
                    Créer mon équipe
                </button>
            </div>

        </form>

    </x-layout_forms>

</section>
