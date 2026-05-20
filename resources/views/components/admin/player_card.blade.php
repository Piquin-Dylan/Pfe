<div class="flex justify-center gap-16 flex-wrap">
    @php
        $players = $playersWithStatus ?? $this->players;
    @endphp

    @foreach($players as $player)

        <div class="relative">
        <span class="text-white absolute font-bold text-xl left-8 top-8">
            {{ $player->name }}
        </span>

            <img class="w-[250px] pb-6"
                 src="{{ asset('Component_card_player.svg') }}"
                 alt="">


            @if(isset($player->pivot->status))

                <span
                    @class([
                        'px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wide border',
                        'bg-green-500/20 text-green-400 border-green-500/40' => $player->pivot->status === 'present',
                        'bg-red-500/20 text-red-400 border-red-500/40' => $player->pivot->status === 'absent',
                        'bg-orange-500/20 text-orange-400 border-orange-500/40' => $player->pivot->status === 'en attente',
                    ])
                >
                    {{ $player->pivot->status }}
                </span>
            @endif
        </div>
    @endforeach
</div>
