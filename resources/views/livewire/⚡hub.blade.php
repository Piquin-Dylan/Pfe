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
    <section>

        @auth
            <div class="flex justify-center items-center gap-3  flex-col">
                <img src="{{asset('f2918708-1aed-4d65-9c03-a2f99ca01212 5.png')}}" alt="">
                <div class="flex justify-center gap-2 p-3">
                    <span class="title_section"> {{Auth::user()->firstName}}</span>
                    <span class="title_section"> {{Auth::user()->lastName}}</span>
                </div>
                <div>
                    <form wire:submit="logout" method="POST">
                        <button class="btn_deconnexion" type="submit">Deconnexion</button>
                    </form>

                </div>
                <span class="title_section">Mes équipes</span>
            </div>
        @endauth

        <div class="lg:flex lg:flex-row">
            @foreach($this->teams as $team)
                <a href="/dashboard">
                <div
                    class=" mt-6 mb-6 mx-6 bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white rounded-2xl p-6 flex flex-col items-center gap-6 transition hover:translate-y-[-5px] ">

                    <div class="flex items-center gap-5">
                        <img class="max-w-36 drop-shadow-[0_15px_30px_rgba(0,0,0,0.6)]" src="{{asset($team->logo)}}"
                             alt="">

                        <span class="text-white text-3xl font-semibold tracking-wide">
            {{$team->name}}
        </span>
                    </div>

                    <div
                        class="w-full border border-white/10 bg-white/5 rounded-xl px-5 py-3 backdrop-blur-sm text-center">
        <span class="text-gray-200 text-sm tracking-wide">
            Code pour rejoindre l'équipe
        </span>
                        <div class="text-white font-mono text-lg tracking-widest mt-1">
                            {{$team->code}}
                        </div>
                    </div>

                    <a href="/dashboard"
                       class="w-full text-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold transition hover:scale-[1.02] hover:brightness-110">
                        Mon dashboard
                    </a>

                </div>
                </a>
            @endforeach

        </div>


    </section>
</div>
