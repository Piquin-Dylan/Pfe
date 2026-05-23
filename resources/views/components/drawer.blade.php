@props([
    'event',
])

<div x-data="{ open: false }">

    <button
        class="btn-form"
        @click="open = true"
    >
        {{ $event }}
    </button>

    <div
        x-show="open"
        x-transition.opacity
        @click.self="open = false"
        class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
        style="display: none;"
    >
        <div
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute top-0 right-0 h-full w-full lg:w-[50vw]
                   bg-[#192443] text-white shadow-2xl
                   p-6 overflow-y-auto"
        >
            <button
                class="mb-6 text-3xl"
                @click="open = false">
                X
            </button>

            {{ $slot }}
        </div>
    </div>

</div>
