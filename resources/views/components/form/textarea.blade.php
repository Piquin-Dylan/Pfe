@props([
    "label_name",
    "label_for",
    "name",
    "id",
    "placeholder",
    "rows",
    "col"





])
<div class="flex flex-col p-6 justify-center">
    <label class=" pb-2 font-bold text-[20px] text-white " for="{{$label_for}}">{{$label_name}}</label>
    <textarea
        {{ $attributes->merge(['class' => 'bg-white p-4 rounded-2xl text-black text-[18px]']) }}
        name="{{ $name }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        rows="{{ $rows }}"
        cols="{{ $col }}"
    ></textarea>
</div>
