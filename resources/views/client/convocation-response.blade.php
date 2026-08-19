<x-layout>
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-24">
        <div class="w-full max-w-lg rounded-3xl border border-violet-500/20 bg-[#1F2243] p-8 text-center shadow-2xl">

            @if($status === 'present')
                <div class="text-5xl mb-4">✅</div>
                <h1 class="text-2xl font-bold text-white mb-2">C'est noté, vous êtes présent(e) !</h1>
            @else
                <div class="text-5xl mb-4">❌</div>
                <h1 class="text-2xl font-bold text-white mb-2">C'est noté, vous êtes absent(e).</h1>
            @endif

            <p class="text-violet-300 mb-6">
                Match du {{ \Carbon\Carbon::parse($match->date_match)->locale('fr')->translatedFormat('d F Y') }}
                à {{ $match->hours }} — {{ $match->address }}
            </p>

            <a href="{{ route('login') }}" class="btn-primary inline-block">
                Retour à l'application
            </a>
        </div>
    </div>
</x-layout>
