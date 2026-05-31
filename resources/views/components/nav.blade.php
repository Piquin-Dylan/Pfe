<nav class="fixed top-0 left-0 right-0 z-50 bg-[#192443]">
    <h2 class="sr-only">Navigation principale</h2>

    <div class="flex items-center justify-between px-6 py-4">
        <a href="{{ route('accueil') }}" class="text-2xl font-bold text-white">
            SportTeams
        </a>

        <button class="relative z-50 sm:hidden text-white" @click="open = !open">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none"
                 viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                      d="M5 7h14M5 12h14M5 17h14"/>
            </svg>

            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 width="56" height="56" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>

        <ul
            :class="{ 'hidden lg:flex': !open, 'flex': open }"
            class="fixed inset-0 z-40 bg-[#192443] text-white items-center justify-center
                   lg:static lg:bg-transparent lg:justify-end">

            <div class="flex flex-col lg:flex-row items-center gap-6 font-semibold">
                <li>
                    <a href="{{ route('accueil') }}"
                       class="{{ request()->routeIs('accueil') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                        Accueil
                    </a>
                </li>

                <li>
                    <a href=""
                       class="{{ request()->routeIs('contact') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                        Contact
                    </a>
                </li>

                @guest
                    <li>
                        <a href="{{ route('register') }}"
                           class="{{ request()->routeIs('register') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                            Inscription
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('login') }}"
                           class="{{ request()->routeIs('login') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                            Connexion
                        </a>
                    </li>
                @endguest

                @auth
                    <li>
                        <a href="{{ route('hub') }}"
                           class="{{ request()->routeIs('hub') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                            Hub
                        </a>
                    </li>
                @endauth

                <li>
                    <a href="{{ route('create') }}"
                       class="{{ request()->routeIs('create') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                        Créer une équipe
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile') }}"
                       class="{{ request()->routeIs('profile') ? 'text-[#BDAEF4] border-b-2 border-[#BDAEF4] font-bold' : '' }} transition-all duration-300 hover:text-[#BDAEF4] hover:-translate-y-0.5">
                        Rejoindre une équipe
                    </a>
                </li>

                @auth
                    <livewire:logout></livewire:logout>
                @endauth
            </div>
        </ul>
    </div>
</nav>
