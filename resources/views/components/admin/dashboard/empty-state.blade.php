@props([
    'title',
    'description',
    'buttonText',
    'href',
    'textColor' => 'text-blue-400',
    'buttonColor' => 'bg-blue-500 hover:bg-blue-600',
])

<div class="bg-gradient-to-br from-[#0f172a] to-[#020617]
           border border-white/10 rounded-3xl p-5 text-white
           flex flex-col items-center justify-center text-center min-h-[200px]">

    <span class="{{ $textColor }} text-lg font-semibold">{{ $title }}</span>
    <p class="text-gray-300 mt-3">{{ $description }}</p>
    <a
        href="{{ $href }}"
        class="mt-5 px-4 py-2 rounded-xl transition {{ $buttonColor }}">
        {{ $buttonText }}
    </a>

</div>
