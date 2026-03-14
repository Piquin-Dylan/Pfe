<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    #[Validate('required')]
    public string $name = '';

    #[Validate('required')]
    public string $email = "";

    #[Validate('required')]
    public string $subject = "";

    #[Validate('required')]
    public string $message = "";

    public function save(): void
    {
        $this->validate();
    }

};
?>


<section>
    <h2 class="hidden">Formulaire de contact</h2>

    <div class="pt-50 pb-50 lg:pr-[150px]  lg:pl-[150px]">
        <form wire:submit="save">
            <div class="sm:flex sm:flex-row sm:flex-wrap ">
            <x-form.input wire:model="name"
                          label_name="Nom complet :"
                          for_label="name"
                          place-holder="Ex : Jean Dupont"
                          type="name"
                          id="name"
                          name="name">
            </x-form.input>
            <x-form.input wire:model="email"
                          label_name="Adresse email : "
                          for_label="email"
                          place-holder="Ex : jean.dupont@gmail.com"
                          type="email"
                          id="email"
                          name="email">
            </x-form.input>
            </div>
            <x-form.input wire:model="$subject"
                          label_name="Sujet :  "
                          for_label="subject"
                          place-holder="Ex : Bug sur la création de compos"
                          type="subject"
                          id="subject"
                          name="subject">
            </x-form.input>
            <x-form.textarea label_name="Message"
                             label_for="message"
                             placeholder="Entrer votre message"
                             type="text"
                             id="message"
                             name="message"
                             col="5"
                             rows="5"
            ></x-form.textarea>
<div class="flex justify-center">
            <x-button class="btn-form" wire:model="submit">Envoyer</x-button>
</div>
        </form>

    </div>
</section>



