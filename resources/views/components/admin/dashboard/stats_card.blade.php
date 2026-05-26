@props([
    'image',
    'title',
    'voir',
    'value',
    'link'
])
<div
    class="relative overflow-hidden rounded-[32px] border border-white/10 bg-[#151822] p-8 min-h-[260px] flex flex-col justify-between">

    <div class="absolute inset-0 bg-gradient-to-r from-[#6D5DFC]/10 via-transparent to-transparent"></div>

    <div class="relative z-10 flex flex-col items-center text-center gap-6">

        <div class="w-28 h-28 rounded-3xl bg-[#241F42] border border-[#5B4BDB]/40 flex items-center justify-center">
            <img src="{{$image}}" class="w-16 h-16" alt="">
        </div>

        <div class="space-y-2">
            <h2 class="text-white text-3xl font-bold">
                {{$value}}
            </h2>

            <p class="text-gray-400 text-lg">
                {{$title}}
            </p>
        </div>
    </div>

    <a href="{{$link}}" class=" text-center relative z-10 text-[#8B74FF] font-semibold text-lg ">
        {{$voir}}
    </a>
</div>
