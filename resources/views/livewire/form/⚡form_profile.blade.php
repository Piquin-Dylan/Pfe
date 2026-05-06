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

        <x-layout_forms
            title_form="Compléter votre profile"
            subtitle_form="Compléter toute les infos utile pour le coach"
            text="Vous n'avez pas encore créer d'équipe ?"
            action="Créer mon équipe"
            redirection="create"
        >

            <form wire:submit.prevent="save" class="space-y-5">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <x-form.input
                        label_name="Nom"
                        for_label="name"
                        placeholder="Dupont"
                        type="text"
                        id="name"
                        name="name"
                        wire:model.live="form.name">

                        @error('form.name')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </x-form.input>

                    <x-form.input
                        label_name="Prénom"
                        for_label="firstName"
                        placeholder="Jean"
                        type="text"
                        id="firstName"
                        name="firstName"
                        wire:model.live="form.firstName">

                        @error('form.firstName')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </x-form.input>

                </div>

                <x-form.input
                    label_name="Poste"
                    for_label="poste"
                    placeholder="Attaquant"
                    type="text"
                    id="poste"
                    name="poste"
                    wire:model.live="form.poste">

                    @error('form.poste')
                    <span class="error">{{ $message }}</span>
                    @enderror

                </x-form.input>

                <x-form.input
                    label_name="Numéro de maillot"
                    for_label="maillot"
                    placeholder="10"
                    type="text"
                    id="maillot"
                    name="maillot"
                    wire:model.live="form.maillot">

                    @error('form.maillot')
                    <span class="error">{{ $message }}</span>
                    @enderror

                </x-form.input>

                <x-form.input
                    label_name="Code équipe"
                    for_label="code"
                    placeholder="ABC123"
                    type="text"
                    id="code"
                    name="code"
                    wire:model.live="form.code">

                    @error('form.code')
                    <span class="error">{{ $message }}</span>
                    @enderror

                </x-form.input>

                <button type="submit"
                        class="w-full text-white py-3 rounded-xl font-semibold bg-gradient-to-r from-purple-500 to-indigo-500 hover:scale-[1.02] transition duration-200 shadow-lg shadow-purple-500/30">
                    Rejoindre mon équipe
                </button>

            </form>

        </x-layout_forms>

    </section>
</div>
