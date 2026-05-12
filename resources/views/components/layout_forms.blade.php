@props([
    'title_form',
    'subtitle_form',
    'text',
    'action',
    'redirection'
]
)


<div class="  relative  flex items-center justify-center min-h-screen px-6 py-6">

    <div class="p-3  w-full max-w-xl backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl lg:p-10 shadow-2xl">

        <div class="mb-8 text-white text-center">
                <span class="text-3xl font-bold">
                    {{$title_form}}
                </span>
            <p class="text-white/60 mt-2">
                {{$subtitle_form}}
            </p>
        </div>


        {{$slot}}
        <div class="text-center text-white/60 text-sm mt-4">
            {{$text}}
            <a href="/{{$redirection}}" class="text-purple-400 font-semibold hover:underline mb-4">
                <span class="mt-4"> {{$action}} </span>
            </a>
        </div>
    </div>
</div>
