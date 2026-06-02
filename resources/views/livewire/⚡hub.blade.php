<?php

use App\Livewire\Forms\CreateEventForm;
use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

new class extends Component {

    public $teams;


    public function mount(): void
    {
        $current_user = Auth::id();


        if (Auth::user()->player) {
            $this->teams = Auth::user()->player->team()->get();

        } else {
            $this->teams = \App\Models\Team::where('user_id', $current_user)->get();
        }


    }
}
?>

<div>
    <section class="lg:flex lg:gap-10 pt-28 lg:px-8 px-4 pb-10">
        <h2 class="sr-only">Hub</h2>

        <div class="flex-1 mt-10 lg:mt-0">

            <div class="mb-10">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    <div>
                        <h3 class="text-white text-2xl lg:text-3xl font-bold mb-3">
                            Mes équipes
                        </h3>

                        <p class="text-gray-400 text-lg lg:text-xl">
                            Gérez vos équipes ou rejoignez une équipe existante.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">

                        <a
                            href="/profile"
                            class="px-6 py-3 rounded-xl border border-white/20
                            text-white font-semibold hover:bg-white/5 transition text-center">
                            Rejoindre une équipe
                        </a>

                        <a href="/create"
                           class="px-6 py-3 rounded-xl bg-gradient-to-r
                            from-blue-600 to-blue-500
                            text-white font-semibold
                            hover:scale-[1.02] transition text-center">
                            Créer une équipe
                        </a>

                    </div>

                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach($this->teams as $team)

                    <a href="/dashboard">

                        <div
                            class="bg-gradient-to-br from-[#0f172a] to-[#020617]
                            border border-white/20 rounded-2xl
                            p-5 flex flex-col gap-5
                            transition hover:-translate-y-1
                            max-w-[500px]">

                            <div class="flex items-center gap-4">

                                <img
                                    class="w-full max-w-24 min-w-32 h-32 object-contain drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]"
                                    src="{{ asset('storage/' . $team->logo) }}"
                                    srcset="{{ asset('storage/' . $team->logo) }} 96w,{{ asset('storage/' . $team->logo) }} 192w,{{ asset('storage/' . $team->logo) }} 384w"
                                    sizes="(max-width: 640px) 64px, 96px"
                                    alt="{{ $team->name }}"
                                    loading="lazy"
                                    decoding="async"
                                />

                                <span class="text-white text-2xl font-semibold tracking-wide">
                                    {{ $team->name }}
                                </span>

                            </div>

                            <div
                                class="w-full border border-white/10 bg-white/5
                                rounded-xl px-4 py-3 backdrop-blur-sm text-center">

                                <span class="text-gray-300 text-sm tracking-wide">
                                    Code pour rejoindre l'équipe
                                </span>

                                <div class="text-white font-mono text-base tracking-[0.3em] mt-2">
                                    {{ $team->code }}
                                </div>

                            </div>

                            <span
                                class="w-full text-center px-5 py-3 rounded-xl
                                bg-gradient-to-r from-blue-600 to-blue-500
                                text-white font-semibold
                                transition hover:brightness-110">
                                Mon dashboard
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>
