@props([
    'title',
    'description',
    'icon',
    'color',
    'action'
])

<button
    wire:click="{{ $action }}"
    class="group rounded-2xl border
           transition-all duration-200
           p-5 text-left
           {{ $color === 'blue'
                ? 'border-blue-500/20 bg-blue-500/10 hover:bg-blue-500/20'
                : 'border-green-500/20 bg-green-500/10 hover:bg-green-500/20' }}"
>

    <div class="flex items-center justify-between">

        <div>
            <h3 class="text-lg font-bold {{ $color === 'blue' ? 'text-blue-400' : 'text-green-400' }}">
                {{ $icon }} {{ $title }}
            </h3>

            <p class="text-slate-300 mt-1">
                {{ $description }}
            </p>
        </div>

        <span class="text-2xl group-hover:translate-x-1 transition {{ $color === 'blue' ? 'text-blue-400' : 'text-green-400' }}">
            →
        </span>

    </div>

</button>
