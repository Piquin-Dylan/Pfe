<?php

use App\Livewire\Forms\CompleteProfileForm;
use App\Models\Player;
use Livewire\Component;

new class extends Component {

    public CompleteProfileForm $form;

    public function save(): void
    {

        $this->validate();

        $team = DB::table('team')->select('id')->where('code', $this->form->code)->value('id');
        $user = Auth::user()->getAuthIdentifier();
        //On fait une requête pour verifier si le code qu'on écrit dans le champs input code correspond avec la column code de la table team
        if (DB::table('team')->where('code', $this->form->code)->exists()) {

            Player::create([
                "team_id" => $team,
                "user_id" => $user,
                "name" => $this->form->name,
                "firstName" => $this->form->firstName,
                "position" => $this->form->poste,
                "maillot" => $this->form->maillot
            ]);
            $this->redirect('/hub');
        }
    }
};
?>

<div>
    <section>
        <div class="flex">
            <div class="mt-12  w-[1400px]">
                <x-title_subtitle_form title="Rejoingnez votre équipe de football"
                                       subtitle="Compléter votre profile et  entrer le code pour rejoindre votre équipe"></x-title_subtitle_form>
                <form wire:submit.prevent="save">
                    <div class="sm:flex sm:flex-row sm:flex-wrap ">
                        <x-form.input
                            label_name="Nom de famille"
                            for_label="name"
                            placeholder=""
                            type="text"
                            id="name"
                            name="name"
                            wire:model.live="form.name" required>
                            <div>
                                @error('form.name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </x-form.input>
                        <x-form.input
                            label_name="Prénom"
                            for_label="firstName"
                            placeholder="Dupont"
                            type="text"
                            id="firstName"
                            name="firstName"
                            wire:model.live="form.firstName" required>
                            <div>
                                @error('form.firstName') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </x-form.input>
                        <x-form.input
                            label_name="Poste sur le terrain"
                            for_label="poste"
                            placeholder=""
                            type="text"
                            id="poste"
                            name="poste"
                            wire:model.live="form.poste" required>
                            <div>
                                @error('form.poste') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </x-form.input>
                        <x-form.input
                            label_name="Numéros de maillot"
                            for_label="maillot"
                            placeholder=""
                            type="text"
                            id="maillot"
                            name="maillot"
                            wire:model.live="form.maillot" required>
                            <div>
                                @error('form.maillot') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </x-form.input>
                        <x-form.input
                            label_name="Code de l'équipe"
                            for_label="code"
                            placeholder=""
                            type="text"
                            id="code"
                            name="code"
                            wire:model="form.code">
                            <div>
                                @error('form.code') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </x-form.input>

                    </div>
                    <div class="flex justify-center gap-2 items-center flex-col">
                        <x-form.button title="Rejoindre une équipe"
                                       text="Rejoindre une équipe" type="submits"></x-form.button>
                        <span class="  text-white  flex justify-center">Pas encore d'équipe
                        <a class="font-bold" href="/connexion">  Créer votre équipe</a> </span>
                    </div>
                </form>

            </div>
            <div>
                <img class="max-w-full h-auto" src="{{asset('photo_form. 2026, 20_36_38.png')}}" alt="">
            </div>
        </div>
    </section>
</div>
