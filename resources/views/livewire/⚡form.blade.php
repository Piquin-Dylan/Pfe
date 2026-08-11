<?php

use App\Livewire\Forms\ContactForm;
use App\Mail\ContactFormSubmitted;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

new class extends Component {

    public ContactForm $form;

    public bool $sent = false;

    public function save(): void
    {
        $this->form->validate();
        $form = $this->form;

        Mail::to(config('mail.contact_form_recipient'))
            ->send(new ContactFormSubmitted(
                $form->name,
                $form->email,
                $form->subject,
                $form->message,
            ));

        $this->form->reset();
        $this->sent = true;
    }

};
?>

<div class="max-w-7xl mx-auto">

<section id="form-contact" class="py-20 px-6 lg:px-8">
    <h2 class="title_section">Formulaire de contact</h2>

    <div class=" ">
        @if ($sent)
            <div class="mb-6 rounded-lg bg-green-600/20 border border-green-500 text-green-300 px-4 py-3 text-center">
                Votre message a bien été envoyé, merci ! Nous vous répondrons rapidement.
            </div>
        @endif
        <form wire:submit.prevent="save">

            <div class="sm:flex sm:gap-5 sm:flex-row sm:flex-wrap ">
                <x-form.input
                    label_name="Nom complet :"
                    for_label="name"
                    place-holder="Ex : Jean Dupont"
                    type="text"
                    id="name"
                    name="name"
                    wire:model="form.name">
                    <div>
                        @error('form.name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-form.input>
                <x-form.input
                    label_name="Adresse email : "
                    for_label="email"
                    place-holder="Ex : jean.dupont@gmail.com"
                    type="email"
                    id="email"
                    name="email"
                    wire:model="form.email">

                    <div>
                        @error('form.email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-form.input>
            </div>
            <x-form.input
                label_name="Sujet :"
                for_label="subject"
                place-holder="Ex : Bug sur la création de compos"
                type="text"
                id="subject"
                name="subject"
                wire:model="form.subject"
            >
                <div>
                    @error('form.subject') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.input>
            <x-form.textarea label_name="Message"
                             label_for="message"
                             placeholder="Entrer votre message"
                             type="text"
                             id="message"
                             name="message"
                             col="5"
                             rows="5"
                             wire:model="form.message">
                <div>
                    @error('form.message') <span class="error">{{ $message }}</span> @enderror
                </div>
            </x-form.textarea>
            <div class="flex justify-center">
                <x-form.button text="Envoyer" type="submit"></x-form.button>
            </div>
        </form>

    </div>
</section>

</div>

