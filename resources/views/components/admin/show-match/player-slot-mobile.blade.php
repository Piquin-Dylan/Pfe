@props(['player', 'attendanceRate' => 0, 'whenSelected' => true, 'placed' => false])

<div x-show="selectedPlayer {{ $whenSelected ? '===' : '!==' }} '{{ $player->position }}'" x-cloak>
    @if($placed)
        <div class="flex items-center justify-between rounded-2xl border border-purple-400/30 bg-[#222547]/70 opacity-80 p-4">
            <div class="flex items-center gap-3">
                <img
                    src="{{ $player->user->image_url }}"
                    alt="{{ $player->firstName }}"
                    class="w-12 h-12 rounded-full object-cover border border-purple-400/30"
                />
                <div>
                    <p class="text-white font-semibold">{{ $player->firstName }}</p>
                    <p class="text-xs text-gray-400 uppercase">{{ $player->position }}</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-2 rounded-full bg-purple-500/10 px-3 py-1 text-xs font-medium text-purple-300">
                <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                Déjà placé
            </span>
        </div>
    @else
        <label class="flex items-center justify-between rounded-2xl border border-purple-500/20 bg-[#25284B] p-4 cursor-pointer hover:bg-[#2D315D] transition">
            <div>
                <p class="text-white font-semibold">{{ $player->firstName }}</p>
                <p class="text-xs text-gray-400 uppercase">{{ $player->position }}</p>
                <x-admin.show-match.attendance-badge :rate="$attendanceRate" />
            </div>
            <input
                type="checkbox"
                class="h-5 w-5 accent-purple-500"
                @click="$wire.assignPlayerToPosition(selectedPlayer, {{ $player->pivot->player_id }}); selectedPlayer = null;">
        </label>
    @endif
</div>
