<?php

use App\Livewire\Forms\CreateTeamForm;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public CreateTeamForm $form;

    public function save(): void
    {
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

            </div>

            {{--<x-form.textarea
                label_name="Description"
                label_for="description"
                name="description"
                id="description"
                rows="5"
                col="6"
                placeholder="Description de votre équipe...">

                @error('form.description')
                <span class="error">{{ $message }}</span>
                @enderror

            </x-form.textarea>
--}}
            <button type="submit"
                    class="w-full text-white py-3 rounded-xl font-semibold bg-gradient-to-r from-purple-500 to-indigo-500 hover:scale-[1.02] transition duration-200 shadow-lg shadow-purple-500/30">
                Créer mon équipe
            </button>

        </form>

    </x-layout_forms>


    {{--<section>
        <div>
            <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">

            </div>
            <div>
                <img class="max-w-full h-auto" src="{{asset('photo_form. 2026, 20_36_38.png')}}" alt="">
            </div>
        </div>
    </section>--}}

</section>
