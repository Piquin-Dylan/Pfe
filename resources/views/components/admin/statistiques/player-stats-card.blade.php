@props(['players'])

@foreach($players as $player)

    <div
        class="bg-[#1A1C38] border border-purple-500/20 rounded-3xl p-4"
    >
        <div class="flex items-center gap-4">

            <div
                class="w-14 h-14 rounded-full bg-[#25284B] flex items-center justify-center flex-shrink-0"
            >
                <span class="text-white font-bold text-lg">
                    {{ substr($player->firstName, 0, 1) }}
                </span>
            </div>

            <div class="flex-1 min-w-0">

                <h2 class="text-white font-semibold truncate">
                    {{ $player->firstName }} {{ $player->name }}
                </h2>

                <p class="text-purple-400 text-sm">
                    {{ $player->position }}
                </p>

            </div>

        </div>

        <div class="mt-4 grid grid-cols-2 gap-3">

            <div
                class="rounded-2xl bg-[#25284B] p-3 text-center"
            >
                <p class="text-xs text-gray-400 uppercase">
                    Sélections
                </p>

                <p class="text-white text-xl font-bold">
                    {{ $player->matches_played ?? 0 }}
                </p>
            </div>

            <div
                class="rounded-2xl bg-[#25284B] p-3 text-center"
            >
                <p class="text-xs text-gray-400 uppercase">
                    Présence
                </p>

                <p class="text-white text-xl font-bold">
                    {{ $player->attendance_percentage }}%
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    {{ $player->presences }}
                </p>
            </div>

        </div>

    </div>

@endforeach
