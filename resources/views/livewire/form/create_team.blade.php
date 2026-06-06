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

        if ($this->form->submit()) {
            $this->redirect('/hub');
        }
    }
};

?>
<section class="pt-20 lg:pt-8">
    <h2 class="sr-only">Formulaire - Créer votre équipe</h2>

    <x-layout_forms
        title_form="Créer votre équipe"
        subtitle_form="Lancez-vous et créez votre première équipe de football !"
        text="Vous voulez rejoindre une équipe ?"
        action="Rejoindre une équipe"
        redirection="profile">


        @if(session()->has('status'))
            <div
                x-data="{ show: true }"
                x-show="show"
                class="text-red-500 text-center text-xl p-4 mt-8 mb-4">
                {{ session('status') }}
            </div>
        @endif

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

                <div class="mb-4 flex flex-col pt-3 justify-center sm:flex-1">

                    <label
                        class="pb-2 font-bold text-[20px] text-white"
                        for="division"
                    >
                        Division de l'équipe
                    </label>

                    <div class="relative">

                        <select
                            id="division"
                            name="division"
                            wire:model.live="form.division"
                            class="input-dark"
                        >
                            <option value="">Sélectionnez une division</option>

                            @foreach(\App\Enums\DivisionEnum::cases() as $division)
                                <option
                                    value="{{ $division->value }}"
                                    class="bg-[#25284B] text-white"
                                >
                                    {{ $division->value }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    @error('form.division')
                    <small class="text-red-500 pt-2">
                        {{ $message }}
                    </small>
                    @enderror

                </div>

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


            <div class="flex justify-center items-center">

                <button type="submit"
                        class="w-full text-white btn-primary">
                    Créer mon équipe
                </button>
            </div>

        </form>

    </x-layout_forms>

</section>
