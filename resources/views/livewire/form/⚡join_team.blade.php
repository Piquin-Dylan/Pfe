<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    #[Validate('required', message: 'Le champs code est requis')]
    public string $code = "";



};
?>

<div>
    <section>
        <div>
        <div class="w-[1400px]">
            <form wire:submit="submit">
                <div class="sm:flex sm:flex-row sm:flex-wrap ">
                    <x-form.input
                        label_name="Code de l'équipe"
                        for_label="code"
                        placeholder=""
                        type="text"
                        id="code"
                        name="code"
                        wire:model="code">
                        <div>
                            @error('code') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </x-form.input>
                </div>
                <div class="flex justify-center">
                    <button class="text-white" type="submit">Rejoindre l'équipe</button>
                </div>
            </form>
        </div>

        </div>
    </section>
</div>
