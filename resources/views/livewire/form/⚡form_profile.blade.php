<?php

use App\Livewire\Forms\CompleteProfileForm;
use App\Models\Player;
use Livewire\Component;

new class extends Component {

    public CompleteProfileForm $form;

    public function save(): void
    {
        $this->validate();

        if (Player::where('user_id', Auth::id())->exists()) {
            $this->addError(
                'form.code',
                'Vous appartenez déjà à une équipe.'
            );
            return;
        }

        $team = DB::table('team')
            ->where('code', $this->form->code)
            ->value('id');

        if (!$team) {
            $this->addError(
                'form.code',
                'Le code d\'équipe est invalide.'
            );
            return;
        }

        Player::create([
            'team_id'   => $team,
            'user_id'   => Auth::id(),
            'name'      => $this->form->name,
            'firstName' => $this->form->firstName,
            'position'  => $this->form->poste,
            'maillot'   => $this->form->maillot,
        ]);

        $this->redirect('/hub');
    }
};
?>

<section>
    <h2 class="sr-only">Formulaire - Compléter votre profile</h2>

    <x-layout_forms
        title_form="Compléter votre profile"
        subtitle_form="Compléter toute les infos utile pour le coach"
        text="Vous n'avez pas encore créer d'équipe ?"
        action="Créer mon équipe"
        redirection="create">

        <form wire:submit.prevent="save" class="space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-form.input
                    label_name="Nom"
                    for_label="name"
                    placeholder="Dupont"
                    type="text"
                    id="name"
                    name="name"
                    wire:model.live="form.name"
                >
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
                    wire:model.live="form.firstName"
                >
                    @error('form.firstName')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </x-form.input>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="pt-3">
                    <label
                        for="post"
                        class="block pb-2 font-bold text-[20px] text-white"
                    >
                        Sélectionner votre poste
                    </label>

                    <div class="relative">
                        <select
                            name="post"
                            id="post"
                            wire:model.live="form.poste"
                            class="w-full px-4 py-3 pr-10 rounded-xl
                           bg-white/5 border border-white/10
                           text-white
                           backdrop-blur-sm
                           appearance-none
                           focus:outline-none
                           focus:ring-2
                           focus:ring-purple-500
                           focus:border-transparent"
                        >
                            <option value="" class="bg-[#1f2333] text-gray-400">
                                Sélectionner votre poste
                            </option>
                            <option value="Gardien" class="bg-[#1f2333]">G</option>
                            <option value="DC" class="bg-[#1f2333]">DC</option>
                            <option value="DCG" class="bg-[#1f2333]">DCG</option>
                            <option value="DCD" class="bg-[#1f2333]">DCD</option>

                            <option value="DD" class="bg-[#1f2333]">DD</option>
                            <option value="DG" class="bg-[#1f2333]">DG</option>

                            <option value="MC" class="bg-[#1f2333]">MC</option>
                            <option value="MCG" class="bg-[#1f2333]">MCG</option>
                            <option value="MCD" class="bg-[#1f2333]">MCD</option>

                            <option value="MOC" class="bg-[#1f2333]">MOC</option>
                            <option value="MCDG" class="bg-[#1f2333]">MCDG</option>
                            <option value="MCDD" class="bg-[#1f2333]">MCDD</option>

                            <option value="BU" class="bg-[#1f2333]">BU</option>
                            <option value="BUG" class="bg-[#1f2333]">BUG</option>
                            <option value="BUD" class="bg-[#1f2333]">BUD</option>

                            <option value="AD" class="bg-[#1f2333]">AD</option>
                            <option value="AG" class="bg-[#1f2333]">AG</option>

                            <option value="MG" class="bg-[#1f2333]">MG</option>
                            <option value="MD" class="bg-[#1f2333]">MD</option>

                            <option value="MDC" class="bg-[#1f2333]">MDC</option>

                            <option value="PistonG" class="bg-[#1f2333]">PistonG</option>
                            <option value="PistonD" class="bg-[#1f2333]">PistonD</option>

                        </select>

                    </div>

                    @error('form.poste')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <x-form.input
                    label_name="Numéro de maillot"
                    for_label="maillot"
                    placeholder="10"
                    type="text"
                    id="maillot"
                    name="maillot"
                    wire:model.live="form.maillot"
                >
                    @error('form.maillot')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </x-form.input>
            </div>

            <x-form.input
                label_name="Code équipe"
                for_label="code"
                placeholder="ABC123"
                type="text"
                id="code"
                name="code"
                wire:model.live="form.code"
            >
                @error('form.code')
                <span class="error">{{ $message }}</span>
                @enderror
            </x-form.input>

            <div class="flex justify-center items-center">

                <button
                    type="submit"
                    class="w-full text-white btn-primary">
                    Rejoindre mon équipe
                </button>
            </div>
        </form>

    </x-layout_forms>

</section>
