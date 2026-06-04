<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
>
    <button
        class="btn-form"
        @click="open = true">
        {{ $event }}
    </button>
    <div
        x-show="open"
        x-transition.opacity.duration.150ms
        @click.self="open = false"
        class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
        style="display: none;">
        <div
            @click.stop
            x-transition:enter="transform transition duration-200"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute top-0 right-0 h-full w-full lg:w-[50vw]
                   bg-[#192443] text-white shadow-2xl
                   px-6 pt-16 pb-6 overflow-y-auto">
            <button
                class="absolute top-4 right-4 sm:top-6 sm:right-6 text-3xl font-light transition hover:scale-110"
                @click="open = false">
                ×
            </button>

            {{ $slot }}

        </div>
    </div>

</div>
