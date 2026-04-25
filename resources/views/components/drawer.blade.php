<div x-data="{ open: false }">

    <button class="btn_deconnexion" x-on:click="open = ! open">Ouvrir</button>

    <div x-show="open"
        :class="{ 'hidden lg:flex': !open, 'flex': open }"
        class=" w-full fixed top-0 left-0 h-full scroll-auto z-40 bg-[#192443]
           text-white flex-col items-center justify-center
           sm:flex">
        <button class="btn_deconnexion" x-on:click="open = ! open">Fermer</button>

        {{$slot}}

    </div>

</div>
