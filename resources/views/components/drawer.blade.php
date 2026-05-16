@props([
    "event",
])

<div x-data="{ open: false }">

    <button class="btn_deconnexion" x-on:click="open = ! open">
        {{ $event }}
    </button>

    <div
        x-show="open"
        :class="{ 'hidden lg:flex': !open, 'flex': open }"
        class="fixed inset-0 z-40
               bg-[#192443]
               text-white
               flex flex-col items-center
               overflow-y-auto
               ">
        <button
            class="btn_deconnexion mb-6"
            x-on:click="open = ! open">
            Fermer
        </button>

        {{ $slot }}
    </div>

</div>
