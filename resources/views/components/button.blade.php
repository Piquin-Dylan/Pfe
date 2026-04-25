<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'px-4 py-2 rounded-lg bg-black text-white hover:bg-gray-800'
    ]) }}
>
    {{ $slot ?? $label }}
</button>
