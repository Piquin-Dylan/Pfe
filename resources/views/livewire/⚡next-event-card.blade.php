<?php

use Livewire\Component;

new class extends Component {
    public $game;
    public $train;

    public function mount(): void
    {
        $team = Auth::user()->player
            ? Auth::user()->player->team
            : Auth::user()->team;

        if ($team) {
            $this->game = $team->games()
                ->whereDate('date_match', '>=', today())
                ->orderBy('date_match')
                ->first();

            $this->train = $team->trains()
                ->whereDate('date_train', '>=', today())
                ->orderBy('date_train')
                ->first();
        }
    }
};
?>

<div class=" pb-8 grid grid-cols-1 lg:grid-cols-2 gap-5 lg:pb-20">

    @if($game)
        <a href="/match/{{ $game->id }}"
           class="group block bg-gradient-to-br from-[#0f172a] to-[#020617]
              border border-white/10 rounded-3xl p-5 text-white
              transition-all duration-300
              hover:-translate-y-1
              hover:border-blue-400/40">

        <span class="text-xs uppercase tracking-widest text-blue-400">
            Prochain match
        </span>

            <div class="mt-4 flex items-center justify-between gap-3">
                @php
                    $team = Auth::user()->team ?? Auth::user()->player?->team;
                @endphp
                <div class="flex flex-col items-center flex-1">
                    @php
                        $logo = in_array($team->logo, [
                            'photos/logo.png',
                            'photos/logo_club.png',
                        ])
                            ? asset($team->logo)
                            : asset('storage/' . $team->logo);
                    @endphp

                    <img
                        src="{{ $logo }}"
                        alt="{{ $team->name }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover"
                    />

                    <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                    {{ $team->name }}
                </span>
                </div>

                <span class="text-xl sm:text-3xl font-bold text-blue-400">
                VS
            </span>

                <div class="flex flex-col items-center flex-1">
                    @php
                        $photoAway = $game->photo_away === 'photos/logo.png'
                            ? asset($game->photo_away)
                            : asset('storage/' . $game->photo_away);
                    @endphp

                    <img
                        src="{{ $photoAway }}"
                        alt="{{ $game->name_away }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover"
                    />

                    <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                    {{ $game->name_away }}
                </span>
                </div>

            </div>

            <div class="mt-5 space-y-2 text-center">
                <p>{{ \Carbon\Carbon::parse($game->date_match)->format('d/m/Y') }}</p>
                <p>{{ $game->hours }}</p>
                <p class="text-gray-300">{{ $game->address }}</p>
            </div>

            <div class="mt-5 flex justify-center">
            <span
                class="inline-flex items-center gap-2 text-blue-400 font-semibold
                       transition-all duration-300
                       group-hover:text-blue-300
                       group-hover:translate-x-1">

                Voir les détails

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </span>
            </div>

        </a>
    @else
        <div
            class="bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white/10 rounded-3xl p-5 text-white flex flex-col items-center justify-center text-center min-h-[200px]">

        <span class="text-blue-400 text-lg font-semibold">
            Aucun match programmé
        </span>

            <p class="text-gray-300 mt-3">
                Créez un match depuis le calendrier.
            </p>

            <a href="{{ route('calendrier') }}"
               class="mt-5 px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 transition">
                Créer un match
            </a>

        </div>
    @endif

    @if($train)
        <a href="/train/{{ $train->id }}"
           class="group block bg-gradient-to-br from-[#0f172a] to-[#020617]
              border border-white/10 rounded-3xl p-5 text-white
              transition-all duration-300
              hover:-translate-y-1
              hover:border-green-400/40">

        <span class="text-xs uppercase tracking-widest text-green-400">
            Prochain entraînement
        </span>

            <div class="flex flex-col items-center justify-center mt-6">

                <div
                    class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white/10 flex flex-col items-center justify-center">

                <span class="text-3xl sm:text-4xl font-bold leading-none">
                    {{ \Carbon\Carbon::parse($train->date_train)->format('d') }}
                </span>

                    <span class="mt-1 text-xs uppercase text-gray-300">
                    {{ \Carbon\Carbon::parse($train->date_train)->locale('fr')->translatedFormat('F') }}
                </span>

                </div>

                <span class="mt-5 text-lg sm:text-2xl font-semibold text-center">
                Entraînement collectif
            </span>

            </div>

            <div class="mt-6 flex flex-col gap-2 text-center">

            <span class="text-base sm:text-lg">
                {{ \Carbon\Carbon::parse($train->hours_start)->format('H\hi') }}
                -
                {{ \Carbon\Carbon::parse($train->hours_end)->format('H\hi') }}
            </span>

                <span class="text-gray-300 break-words">
                {{ $train->address }}
            </span>

            </div>

            <div class="mt-6 flex justify-center">
            <span
                class="inline-flex items-center gap-2 text-green-400 font-semibold
                       transition-all duration-300
                       group-hover:text-green-300
                       group-hover:translate-x-1">

                Voir les détails

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </span>
            </div>

        </a>
    @else
        <div
            class="bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white/10 rounded-3xl p-5 text-white flex flex-col items-center justify-center text-center min-h-[200px]">

        <span class="text-green-400 text-lg font-semibold">
            Aucun entraînement programmé
        </span>

            <p class="text-gray-300 mt-3">
                Créez un entraînement depuis le calendrier.
            </p>

            <a href="{{ route('calendrier') }}"
               class="mt-5 px-4 py-2 rounded-xl bg-green-500 hover:bg-green-600 transition">
                Créer un entraînement
            </a>

        </div>
    @endif

</div>
