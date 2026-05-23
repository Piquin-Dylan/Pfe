@props([
    "text",
    "type",
])
<div class="flex justify-center items-center">
<button class="btn-form items-center cursor-pointer" type="{{$type}}">{{$text}}</button>
</div>
