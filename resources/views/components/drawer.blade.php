<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"

    x-on:{{ $openEvent }}.window="open = true"
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
        style="display:none;"
    >
        <div
            @click.stop
            class="absolute top-0 right-0 h-full w-full lg:w-[50vw]
                   bg-[#192443] text-white shadow-2xl
                   px-6 pt-16 pb-6 overflow-y-auto">

            <button
                class="absolute top-4 right-4 text-3xl"
                @click="open = false">
                ×
            </button>

            {{ $slot }}

        </div>
    </div>
</div>
