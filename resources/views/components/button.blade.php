<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => ''
    ]) }}
>
    {{ $slot ?? $label }}
</button>
