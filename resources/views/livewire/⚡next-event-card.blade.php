<?php

use Livewire\Component;

new class extends Component {
    public $game;
    public $train;

    public function mount(): void
    {
        $this->game = Auth::user()->team
            ->games()
            ->where('date_match', '>=', now())
            ->orderBy('date_match', 'asc')
            ->first();

        $this->train = Auth::user()->team
            ->trains()
            ->where('date_train', '>=', now())
            ->orderBy('date_train', 'asc')
            ->first();
    }
};
?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    @if($game)
        <div class="bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white/10 rounded-3xl p-5 text-white">

            <span class="text-xs uppercase tracking-widest text-blue-400">
                Prochain match
            </span>

            <div class="mt-4 flex items-center justify-between gap-3">

                <div class="flex flex-col items-center flex-1">
                    <img
                        src="{{ asset('storage/'.$game->photo_home) }}"
                        alt="{{ $game->name_home }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover"
                    >

                    <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                        {{ $game->name_home }}
                    </span>
                </div>

                <span class="text-xl sm:text-3xl font-bold text-blue-400">
                    VS
                </span>

                <div class="flex flex-col items-center flex-1">
                    <img
                        src="{{ asset('storage/'.$game->photo_away) }}"
                        alt="{{ $game->name_away }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover"
                    >

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

        </div>
    @endif

    @if($train)
        <div class="bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white/10 rounded-3xl p-5 text-white">

            <span class="text-xs uppercase tracking-widest text-green-400">
                Prochain entraînement
            </span>

            <div class="flex flex-col items-center justify-center mt-6">

                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white/10 flex flex-col items-center justify-center">

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

        </div>
    @endif

</div>
