<div
    x-show="open"
    @click="open = false"
    class="fixed inset-0 bg-black/50 z-30 lg:hidden"
></div>

<div class="flex-1 flex flex-col lg:ml-64">

    <header class="bg-[#192443] border-b border-white/10 px-3 py-2">

        <div class="flex items-center justify-between gap-3">

            <button class="relative z-50 lg:hidden shrink-0" @click="open = !open">

                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M5 7h14M5 12h14M5 17h14"/>
                </svg>

                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M6 18 18 6M6 6l12 12"/>
                </svg>

            </button>

            <a
                href="{{ route('dashboard') }}"
                class="hidden sm:block text-white font-semibold text-base lg:text-lg shrink-0"
            >
                SportTeams
            </a>

            <div class="relative shrink-0">
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
                        class="absolute -top-2 -right-2 min-w-5 h-5 px-1 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold leading-none shadow-md">
                        {{ Auth::user()->unreadNotifications()->count() }}
                    </span>
                </a>
            </div>

        </div>

        <div class="mt-1 text-center text-white lg:mt-2">
            <span class="block text-[10px] sm:text-xs text-gray-300">
                Code équipe
            </span>

            <span class="block text-xs sm:text-sm lg:text-base font-medium break-all">
                {{ Auth::user()->team?->code ?? Auth::user()->player?->team?->code }}
            </span>
        </div>

    </header>

    <main class="flex-1 p-3 sm:p-6 overflow-y-auto">
        {{ $slot }}
    </main>

</div>
