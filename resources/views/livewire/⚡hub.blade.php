<?php

use App\Livewire\Forms\CreateEventForm;
use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Livewire\Component;

new class extends Component {

    public string $searchPlayer = "";
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


    //Permet de pouvoir déconnecter un utilisateur qui est sur le hub en appuyant sur le bouton deconnexion
    public function logout(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
?>

<div>
    <section class="lg:flex lg:gap-10 lg:pt-8 lg:pr-8">

        @auth
            <aside class="lg:w-72 shrink-0 flex justify-center">
                <div class="flex flex-col justify-center items-center lg:items-start gap-4">
                    <img
                        src="{{ asset('f2918708-1aed-4d65-9c03-a2f99ca01212 5.png') }}"
                        alt="Photo de profil"
                        class="w-36"
                    >

                    <div class="text-center lg:text-left">
                        <h2 class="title_section">
                            {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
                        </h2>
                    </div>

                    <form wire:submit="logout" method="POST">
                        <button class="btn_deconnexion" type="submit">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </aside>
        @endauth

        <div class="flex-1 mt-10 lg:mt-0">

            <div class="mb-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-white text-2xl font-bold mb-3">
                            Mes équipes
                        </h1>

                        <p class="text-gray-400 text-xl">
                            Gérez vos équipes ou rejoignez une équipe existante.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a
                            href="/join-team"
                            class="px-6 py-3 rounded-xl border border-white/20
                                   text-white font-semibold hover:bg-white/5 transition">
                            Rejoindre une équipe
                        </a>

                        <a
                            href="/create-team"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r
                                   from-blue-600 to-blue-500
                                   text-white font-semibold
                                   hover:scale-[1.02] transition"
                        >
                            Créer une équipe
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-6">
                @foreach($this->teams as $team)
                    <a href="/dashboard">
                        <div
                            class="bg-gradient-to-br from-[#0f172a] to-[#020617]
                                   border border-white rounded-2xl p-6
                                   flex flex-col gap-6
                                   transition hover:-translate-y-1"
                        >
                            <div class="flex items-center gap-5">
                                <img
                                    class="max-w-28 drop-shadow-[0_15px_30px_rgba(0,0,0,0.6)]"
                                    src="{{ asset($team->logo) }}"
                                    alt="{{ $team->name }}"
                                >

                                <span class="text-white text-3xl font-semibold tracking-wide">
                                    {{ $team->name }}
                                </span>
                            </div>

                            <div
                                class="w-full border border-white/10 bg-white/5
                                       rounded-xl px-5 py-3 backdrop-blur-sm text-center"
                            >
                                <span class="text-gray-200 text-sm tracking-wide">
                                    Code pour rejoindre l'équipe
                                </span>

                                <div class="text-white font-mono text-lg tracking-widest mt-1">
                                    {{ $team->code }}
                                </div>
                            </div>

                            <span
                                class="w-full text-center px-6 py-3 rounded-xl
                                       bg-gradient-to-r from-blue-600 to-blue-500
                                       text-white font-semibold
                                       transition hover:scale-[1.02] hover:brightness-110"
                            >
                                Mon dashboard
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>
