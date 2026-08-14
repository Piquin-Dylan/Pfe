@props(['player'])

<span class="absolute z-30 text-white font-bold text-xl left-2 top-6">{{ $player->firstName }}</span>
<span class="absolute z-30 text-white font-bold text-xl left-2 top-80">{{ $player->position }}</span>

<img
    class="absolute z-20 inset-0 w-full h-full object-cover"
    style="clip-path: polygon(13% 15%,52% 15%,60% 7%,86% 7%,92% 12%,92% 88%,85% 94%,50% 94%,42% 84%,13% 84%);"
    src="{{ $player->user->image_url }}"
    alt="{{ $player->firstName }}">

<div class="absolute z-30 bottom-[60px] right-[28px] w-[55px] h-[55px] rounded-full bg-[#A6463A] flex items-center justify-center text-white text-4xl font-bold">
    {{ $player->maillot }}
</div>

<img
    class="relative z-10 w-full"
    src="{{ asset('Component_card_player.svg') }}"
    alt="">
