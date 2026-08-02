<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @livewireStyles

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @include('partials.vite-or-fallback-styles')
</head>
<body
    x-data="{ open: false }"
    :class="{ 'overflow-hidden': open }"
    class="bg-[#0F172A] text-white">
    <h1 class="sr-only">Pfe - SportTeams</h1>
    <div class="flex min-h-screen">

        <aside
            :class="{ '-translate-x-full': !open, 'translate-x-0': open }"
            class="fixed top-0 left-0 h-full w-64 bg-[#192443] z-40 transform transition duration-300 lg:translate-x-0">
            <h2 class="sr-only">
                Navigation principale
            </h2>
            <nav class="h-full flex flex-col items-center justify-center ">
                <h3 class="sr-only">
                    Menu de navigation
                </h3>
                <ul class="flex flex-col gap-6 text-2xl font-semibold text-white w-full px-6">

                    <li>
                        <a href="/dashboard"
                           class="block w-full px-4 py-3 rounded-xl transition-all duration-200 text-center
                   {{ request()->is('dashboard') ? 'bg-[#7C3AED]' : 'hover:bg-[#8B5CF6] active:bg-[#6D28D9]' }}">
                            Accueil
                        </a>
                    </li>

                    <li>
                        <a id="match" href="/match"
                           class="block w-full px-4 py-3 rounded-xl transition-all duration-200 text-center
                   {{ request()->is('match') ? 'bg-[#7C3AED]' : 'hover:bg-[#8B5CF6] active:bg-[#6D28D9]' }}">
                            Match
                        </a>
                    </li>

                    <li>
                        <a id="train" href="/train"
                           class="block w-full px-4 py-3 rounded-xl transition-all duration-200 text-center
                   {{ request()->is('train') ? 'bg-[#7C3AED]' : 'hover:bg-[#8B5CF6] active:bg-[#6D28D9]' }}">
                            Entrainement
                        </a>
                    </li>

                    <li>
                        <a id="team" href="/team"
                           class="block w-full px-4 py-3 rounded-xl transition-all duration-200 text-center
                   {{ request()->is('team') ? 'bg-[#7C3AED]' : 'hover:bg-[#8B5CF6] active:bg-[#6D28D9]' }}">
                            Equipe
                        </a>
                    </li>

                    <li>
                        <a id="calendrier" href="/calendrier"
                           class="block w-full px-4 py-3 rounded-xl transition-all duration-200 text-center
                   {{ request()->is('calendrier') ? 'bg-[#7C3AED]' : 'hover:bg-[#8B5CF6] active:bg-[#6D28D9]' }}">
                            Calendrier
                        </a>
                    </li>
                    @php
                        $image = Auth::user()->image === 'photos/person.png'
                            ? asset(Auth::user()->image)
                            : asset('storage/' . Auth::user()->image);
                    @endphp

                    <li class="flex justify-center">
                        <a id="settings" href="{{ route('settings') }}">
                            <img
                                src="{{ $image }}"
                                alt="Photo de profil"
                                class="w-28 h-28 rounded-full object-cover border-2 border-white/20 hover:border-purple-400 transition">
                        </a>
                    </li>


                    <li>
                        @livewire('admin.dashboard')
                    </li>
                </ul>
            </nav>
        </aside>
        <div
            x-show="open"
            @click="open = false"
            class="fixed inset-0  z-30 lg:hidden"></div>

        <div class="flex-1 flex flex-col lg:ml-64">

            <div class="bg-[#192443] h-16 lg:h-16 flex items-center px-3 lg:px-4 border-b border-white/10">

                <button class="relative z-50 lg:hidden shrink-0 text-white" @click="open = !open">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                              d="M5 7h14M5 12h14M5 17h14"/>
                    </svg>

                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                              d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="ml-2 lg:ml-4 flex items-center w-full text-white">

                    <div class="font-semibold text-lg hidden lg:block">
                        <a href="{{ route('dashboard') }}">SportTeams</a>
                    </div>

                    <div class="flex-1 flex justify-center">
            <span class="text-[11px] sm:text-sm lg:text-base text-center break-all lg:break-normal">
                <span class="lg:hidden">
                    {{ Auth::user()->team?->code ?? Auth::user()->player?->team?->code }}
                </span>

                <span id="code" class="hidden lg:inline">
                    Code pour rejoindre l'équipe :
                    {{ Auth::user()->team?->code ?? Auth::user()->player?->team?->code }}
                </span>
            </span>
                    </div>

                </div>

                <div class="ml-2 lg:ml-4 flex items-center gap-4 shrink-0">

                    <button
                        id="tutorial-button"
                        title="Revoir le tutoriel"
                        class="cursor-pointer flex items-center gap-2 text-white hover:text-purple-400 transition-colors">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 lg:w-6 lg:h-6"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"/>
                            <path d="M12 17h.01"/>
                        </svg>

                        <span class="hidden lg:inline text-sm">
                            Revoir tutoriel</span>
                    </button>

                    <div class="relative inline-flex">
                        <a href="/message">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 lg:w-6 lg:h-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="white"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>

                            <span
                                class="absolute -top-2 -right-2 min-w-5 h-5 px-1
                    flex items-center justify-center
                    rounded-full bg-red-500 text-white
                    text-[10px] font-bold leading-none shadow-md">
                    {{ Auth::user()->unreadNotifications()->count() }}
                </span>
                        </a>
                    </div>

                </div>

            </div>

            <main class="flex-1 p-3 sm:p-6 overflow-y-auto">
                {{ $slot }}
            </main>

        </div>
    </div>

    @livewireScripts
</body>
</html>
