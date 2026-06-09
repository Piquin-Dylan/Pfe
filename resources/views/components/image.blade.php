@props([
    'path',
    'alt' => '',
    'contain' => false,
])

@php
    $url = str_starts_with($path, 'photos/')
        ? asset($path)
        : asset('storage/' . $path);
@endphp

<img
    src="{{ $url }}"
    srcset="
        {{ $url }} 128w,
        {{ $url }} 256w,
        {{ $url }} 512w
    "
    sizes="(max-width: 640px) 128px, (max-width: 1024px) 256px, 512px"
    alt="{{ $alt }}"
    loading="lazy"
    decoding="async"
    {{ $attributes->class([
        'object-cover' => !$contain,
        'object-contain' => $contain,
    ]) }}
>
