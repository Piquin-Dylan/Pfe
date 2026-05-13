@props([
    'title_form',
    'subtitle_form',
    'text',
    'action',
    'redirection'
])

<div class="relative flex items-center justify-center min-h-screen px-4 py-4">
    <div class="w-full max-w-5xl backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl shadow-2xl">
        <div class="p-4 lg:p-6">

            <div class="mb-4 text-white text-center">
                <span class="text-2xl lg:text-3xl font-bold">
                    {{ $title_form }}
                </span>

                <p class="text-white/60 mt-1 text-sm lg:text-base">
                    {{ $subtitle_form }}
                </p>
            </div>

            {{ $slot }}

            <div class="text-center text-white/60 text-xs lg:text-sm mt-4">
                {{ $text }}
                <a
                    href="/{{ $redirection }}"
                    class="text-purple-400 font-semibold hover:underline"
                >
                    {{ $action }}
                </a>
            </div>
        </div>
    </div>
</div>
