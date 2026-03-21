<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    #[Validate('required', message: 'Le champs code est requis')]
    public string $code = "";


    public function submit(): void
    {

        $this->validate();

        //On fait une requête pour verifier si le code qu'on écrit dans le champs input code correspond avec la column code de la table team
        if (DB::table('team')->where('code', $this->code)->exists()) {
            $this->redirect('/');
        } else {
            $this->redirect('/inscription');

        }


    }
};
?>

<div>
    <section>
        <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
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
    </section>
</div>
