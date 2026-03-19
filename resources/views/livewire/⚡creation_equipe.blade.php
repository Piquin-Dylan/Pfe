<?php

use Livewire\Component;

new class extends Component {
    //
};


?>
<div>
    <section>
        <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
            <form wire:submit.prevent="save">
                <div class="sm:flex sm:flex-row sm:flex-wrap ">
                    <x-form.input
                        label_name="Nom de l'équipe"
                        for_label="name_team"
                        placeholder="Ex : Standard"
                        type="text"
                        id="name_team"
                        name="name_team"
                        wire:model.live="form.firstName">
                        <div>
                            @error('form.firstName') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                        label_name="Ville de l'équipe"
                        for_label="ville"
                        placeholder="Dupont"
                        type="text"
                        id="ville"
                        name="ville"
                        wire:model.live="form.lastName">
                        <div>
                            @error('form.lastName') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                        label_name="Division de l'équipe"
                        for_label="division"
                        placeholder="Ex : jean.dupont@gmail.com"
                        type="text"
                        id="division"
                        name="division"
                        wire:model.live="form.email">
                        <div>
                            @error('form.email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                    <x-form.input
                        label_name="Logo du club"
                        for_label="logo"
                        placeholder=""
                        type="file"
                        id="logo"
                        name="logo"
                        wire:model.live="form.password">
                        <div>
                            @error('form.password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
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
