@props([
    "label_name",
    "type",
    "placeholder" => '',
    "for_label",
    "name",
    "id",
])
{{--@php
    $wireModel = $attributes->wire('model');
    $wireTarget = null;

    if ($loading !== false) {
    if ($loading === true) {
    $loading = true;
    } elseif ($wireModel?->directive) {
    $loading = $wireModel->hasModifier('live');
    $wireTarget = $loading ? $wireModel->value() : null;
    } else {
    $wireTarget = $loading;
    $loading = (bool) $loading;
    }
    }
@endphp--}}


<div class="flex flex-col p-6 justify-center sm:flex-1">

    <label class="pb-2 font-bold text-[20px] text-white" for="{{ $for_label }}">
        {{ $label_name }}

    </label>

    <input
            {{ $attributes->merge([
                'class' => 'bg-white p-4 rounded-2xl text-black text-[18px]'
            ]) }}
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            name="{{ $name }}"
            id="{{ $id }}">
    @error('form.' . $name)
    <small class="text-red-500 pt-2">
        {{ $message }}
    </small>
    @enderror


</div>
