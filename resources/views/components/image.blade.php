@props([
    'path',
    'alt' => '',
    'class' => '',
    'sizes' => '(max-width: 768px) 50vw, 20vw',
])

@php
    $isSeeded = str_starts_with($path ?? '', 'photos/');
@endphp

@if($isSeeded)

    <img
        src="{{ asset($path) }}"
        alt="{{ $alt }}"
        class="{{ $class }}"
        loading="lazy"
        decoding="async"
    >

@else

    <img
        src="{{ Storage::url('pictures/originals/' . $path) }}"
        srcset="
            {{ Storage::url('pictures/variants/300x300/' . $path) }} 300w,
            {{ Storage::url('pictures/variants/600x600/' . $path) }} 600w,
            {{ Storage::url('pictures/variants/900x900/' . $path) }} 900w
        "
        sizes="{{ $sizes }}"
        alt="{{ $alt }}"
        class="{{ $class }}"
        loading="lazy"
        decoding="async"
    >

@endif
