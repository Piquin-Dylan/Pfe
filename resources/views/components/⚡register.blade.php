<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    #[Validate('required')]
    public string $firstName = '';

    #[Validate('required')]
    public string $lastName = "";

    #[Validate('required')]
    public string $email = "";

    #[Validate('required')]
    public string $password = "";

    public function save(): void
    {
        $this->validate();
    }

};
?>


<section>
    <h2 class="hidden">Formulaire d'inscription</h2>

    <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
        <form wire:submit="save">
            <div class="sm:flex sm:flex-row sm:flex-wrap ">
                <x-form.input wire:model="firstName"
                              label_name="Prénom"
                              for_label="name"
                              place-holder="Ex : Jean"
                              type="name"
                              id="name"
                              name="name">
                </x-form.input>
                <x-form.input wire:model="lastName"
                              label_name="lastName"
                              for_label="email"
                              place-holder="Ex : Dupont"
                              type="text"
                              id="lastName"
                              name="lastName">
                </x-form.input>
            </div>
            <x-form.input wire:model="email"
                          label_name="Adresse email : "
                          for_label="email"
                          place-holder="Ex : jean.dupont@gmail.com"
                          type="email"
                          id="email"
                          name="email">
            </x-form.input>
            <x-form.input wire:model="password"
                          label_name="password"
                          for_label="password"
                          place-holder=""
                          type="password"
                          id="password"
                          name="password">
            </x-form.input>

            <div class="flex justify-center">
                <x-button class="btn-form" wire:model="submit">Inscription</x-button>
            </div>
        </form>

    </div>
</section>
