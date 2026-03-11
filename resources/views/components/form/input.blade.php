@props([
    "label_name",
    "type",
    "placeHolder" => '',
    "for_label",
    "name",
    "id",
    "isRequired" => true
])

<div class="flex flex-col p-6 justify-center sm:flex-1 ">
    <label class=" pb-2 font-bold text-[20px] text-white " for="{{$for_label}}">{{ $label_name}}
    </label>
    <input class="bg-white p-4 rounded-2xl text-black [18px]" type="{{$type}}" placeholder="{{$placeHolder}}" name="{{$name}}" id="{{$id}} {{$attributes}}"
           @if($isRequired)
               required
        @endif>
</div>
