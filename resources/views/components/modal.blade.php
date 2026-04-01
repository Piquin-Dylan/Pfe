<div class="text-white" x-data="{ expanded: false }">
    <button class="" type="button" x-on:click="expanded = ! expanded">
        <span x-show="! expanded">Show post content...</span>
        <span x-show="expanded">Hide post content...</span>
    </button>


    <div class="bg-white modal w-96 background_modal" x-show="expanded">
        <form class="flex">
            <x-form.input
                label_name="Nom"
                for_label="name"
                placeholder=""
                type="text"
                id="name"
                name="name"
                value="<?php echo Auth::user()->lastName; ?>"
            >
            </x-form.input>
            <x-form.input
                label_name="Prénom"
                for_label="firstName"
                placeholder=""
                type="text"
                id="firstName"
                name="firstName"
                value="<?php echo Auth::user()->firstName; ?>">
            </x-form.input>
            <x-form.input
                label_name="Adresse mail"
                for_label="email"
                placeholder=""
                type="email"
                id="email"
                name="email"
                value="<?php echo Auth::user()->email; ?>">
            </x-form.input>
            <x-form.input
                label_name="Mot de passe"
                for_label="password"
                placeholder=""
                type="password"
                id="password"
                name="password"
                value="<?php echo Auth::user()->password; ?>">
            </x-form.input>
        </form>
    </div>
</div>
