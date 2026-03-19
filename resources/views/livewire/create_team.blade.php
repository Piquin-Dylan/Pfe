<?php

use App\Livewire\Forms\CreateTeamForm;
use Livewire\Component;

new class extends Component {
    public CreateTeamForm $form;

    public function save(): void
    {
        $this->form->submit();
    }
};


?>
<div>
    <section>
        <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
            <form wire:submit.prevent="save">
                <div class="sm:flex sm:flex-row sm:flex-wrap ">
                    <x-form.input
                            label_name="Nom de l'équipe"
                            for_label="name"
                            placeholder="Ex : Standard"
                            type="text"
                            id="name"
                            name="name"
                            wire:model.live="form.name" required>
                        <div>
                            @error('form.name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                            label_name="Ville de l'équipe"
                            for_label="ville"
                            placeholder="Dupont"
                            type="text"
                            id="ville"
                            name="ville"
                            wire:model.live="form.ville" required>
                        <div>
                            @error('form.ville') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                            label_name="Division de l'équipe"
                            for_label="division"
                            placeholder=""
                            type="text"
                            id="division"
                            name="division"
                            wire:model.live="form.division" required>
                        <div>
                            @error('form.division') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    {{--     <x-form.input
                                 label_name="Logo du club"
                                 for_label="logo"
                                 placeholder=""
                                 type="file"
                                 id="logo"
                                 name="logo"
                                 wire:model.live="form.logo" required>
                             <div>
                                 @error('form.logo') <span class="error">{{ $message }}</span> @enderror
                             </div>
                         </x-form.input>--}}
                </div>
                <x-form.textarea label_name="Description" label_for="description" name="description"
                                 id="description" rows="10" col="10" placeholder=""></x-form.textarea>
                <div class="flex justify-center">
                    <button class="text-white" type="submit">Créer mon équipe</button>
                </div>
            </form>

        </div>
    </section>

</div>
