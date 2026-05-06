@props([
    "label_name",
    "type",
    "placeholder" => '',
    "for_label",
    "name",
    "id",
])

<div class="flex flex-col pt-3 justify-center sm:flex-1">

    <label class="pb-2 font-bold text-[20px] text-white" for="{{ $for_label }}">
        {{ $label_name }}

    </label>

    <input
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes }}
        class="input-dark"
    >
    @error('form.' . $name)
    <small class="text-red-500 pt-2">
        {{ $message }}
    </small>
    @enderror


</div>
