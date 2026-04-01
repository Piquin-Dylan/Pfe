<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {


    public string $firstName = "";
    public string $lastName = "";


    #[Validate('email')]
    #[Validate('unique:users')]
    public string $email = "";

    public string $password = "";


    public function update(): void
    {
        $this->validate();


        $user = DB::table('users')->where('id', Auth::user()->getAuthIdentifier())->update([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => Hash::make($this->password, [
                'rounds' => "12",
            ]),
        ]);

        $this->redirect('/hub');
    }

   public function mount(): void
    {

        $this->firstName = Auth::user()->firstName;

        $this->lastName = Auth::user()->lastName;

        $this->email = Auth::user()->email;

    }
};

?>

<div>
    <section>

        <div class=" pt-12 lg:pr-[150px]  lg:pl-[150px]">
            <x-title_subtitle_form title="Profile"
                                   subtitle="Modifier mon profile"></x-title_subtitle_form>
            <form wire:submit.prevent="update">
                <div class="sm:flex sm:flex-row sm:flex-wrap ">
                    <x-form.input
                        label_name="Nom"
                        for_label="lastName"
                        placeholder=""
                        type="text"
                        id="lastName"
                        name="lastName"
                        wire:model="lastName">
                    </x-form.input>
                    <x-form.input
                        label_name="Prénom"
                        for_label="firstName"
                        placeholder=""
                        type="text"
                        id="firstName"
                        name="firstName"
                        wire:model="firstName">
                    </x-form.input>
                    <x-form.input
                        label_name="Adresse mail"
                        for_label="email"
                        placeholder=""
                        type="email"
                        id="email"
                        name="email"
                        wire:model="email">

                    </x-form.input>
                    <x-form.input
                        label_name="Mot de passe"
                        for_label="password"
                        placeholder=""
                        type="password"
                        id="password"
                        name="password"
                        wire:model="password">
                    </x-form.input>
                </div>
                <div class="flex justify-center gap-2 items-center flex-col">
                    <x-form.button text="Modifier" type="submit"></x-form.button>
                </div>
            </form>

        </div>
    </section>
</div>
