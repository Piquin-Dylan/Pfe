<nav class="relative">
    <h2 class="sr-only">Navigation principale </h2>
    <div class="">
        <button class=" relative z-50 sm:hidden" @click="open = !open">
            <svg x-show="!open" class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 width="56"
                 height="56" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                      d="M5 7h14M5 12h14M5 17h14"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="56"
                 height="56"
                 strokeWidth={1.5} stroke="currentColor" className="size-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <ul
        :class="{ 'hidden lg:flex': !open, 'flex': open }"
        class="fixed inset-0 z-40 bg-[#192443] text-white items-center justify-center
           lg:static lg:bg-transparent lg:justify-end lg:pr-10">
        <div class="flex flex-col lg:flex-row items-center gap-6 text-shadow-xs sticky lg:p-6 font-semibold">
            <li><a title="vers la page d'accueil" href="{{route('accueil')}}">Accueil</a></li>
            <li><a title="vers la page de contact" href="">Contact</a></li>
            @guest
                <li><a title="vers la page d'inscription" href="{{route('register')}}">Inscription</a></li>
                <li><a title="vers la page de connexion" href="{{route('login')}}">Connexion</a></li>
            @endguest
            @auth
                <li><a title="vers la page de connexion" href="{{route('hub')}}">Hub</a></li>

            @endauth

            <li><a title="vers la page de création d'équipe" href="{{route('create')}}">Créer une équipe</a></li>
            <li><a title="vers la page rejoindre une équipe" href="{{route('join')}}">Rejoindre une équipe</a></li>
            @auth
                <livewire:logout></livewire:logout>
            @endauth
        </div>
    </ul>
</nav>
