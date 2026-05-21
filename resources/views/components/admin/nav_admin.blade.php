<div
    x-show="open"
    @click="open = false"
    class="fixed inset-0 bg-black/50 z-30 lg:hidden"
></div>

<div class="flex-1 flex flex-col lg:ml-64">

    <header class="bg-[#192443] h-16 flex items-center px-4 border-b border-white/10">

        <button class="relative z-50 lg:hidden" @click="open = !open">

            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                 viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                      d="M5 7h14M5 12h14M5 17h14"/>
            </svg>

            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"
                 viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                      d="M6 18 18 6M6 6l12 12"/>
            </svg>

        </button>

        <div class="ml-4 flex items-center w-full text-white">

            <div class="font-semibold text-lg">
                <a href="{{ route('dashboard') }}">SportTeams</a>
            </div>

            <div class="flex-1 flex justify-center">
        <span>
            Code pour rejoindre l'équipe :
            {{ Auth::user()->team?->code ?? Auth::user()->player?->team?->code }}
        </span>
            </div>
        </div>
        <div class="ml-4 relative inline-flex">
            <a href="/message">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6"
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
               text-[10px] font-bold leading-none
               shadow-md">
            {{Auth::user()->unreadNotifications()->count()}}
    </span>
            </a>
        </div>

    </header>
    <main class="flex-1 p-6 overflow-y-auto">
        {{ $slot }}
    </main>
</div>
