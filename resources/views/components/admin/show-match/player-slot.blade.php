@props(['player', 'attendanceRate' => 0, 'whenSelected' => true, 'placed' => false])

<div
    x-show="selectedPlayer {{ $whenSelected ? '===' : '!==' }} '{{ $player->position }}'"
    x-cloak
    @if(!$placed)
    @click="$wire.assignPlayerToPosition(selectedPlayer, {{ $player->pivot->player_id }})"
    @endif
    @class([
        'flex items-center justify-between rounded-2xl border p-4 transition',
        'border-purple-500/10 bg-[#222547] cursor-pointer hover:bg-[#2A2E57]' => !$placed,
        'border-purple-400/30 bg-[#222547]/70 opacity-80 cursor-not-allowed' => $placed,
    ])
>
    <div class="flex items-center gap-3">
        <img
            src="{{ $player->user->image_url }}"
            alt="{{ $player->firstName }}"
            class="w-12 h-12 rounded-full object-cover border border-purple-400/30"
        />

        <div>
            <p class="text-white font-semibold">{{ $player->firstName }}</p>
            <p class="text-xs text-gray-400 uppercase">{{ $player->position }}</p>
            @unless($placed)
                <x-admin.show-match.attendance-badge :rate="$attendanceRate" />
            @endunless
        </div>
    </div>

    @if($placed)
        <span class="inline-flex items-center gap-2 rounded-full bg-purple-500/10 px-3 py-1 text-xs font-medium text-purple-300">
            <span class="h-2 w-2 rounded-full bg-purple-400"></span>
            Déjà placé
        </span>
    @else
        <div class="h-4 w-4 rounded-full border border-gray-400"></div>
    @endif
</div>
