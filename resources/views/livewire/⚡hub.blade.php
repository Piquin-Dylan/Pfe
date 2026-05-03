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
                    <img src="{{asset(Auth::user()->image)}}">

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
                <div class=" card_hub flex items-center flex-col gap-8 flex-wrap ">
                    <a href="/dashboard">
                        <span class="text-white">{{$team->name}}</span>
                        <span class="text-white">{{$team->division}}</span>
                        <span class="text-white">{{$team->ville}}</span>
                        <span class="text-white">{{$team->code}}</span>
                    </a>
                </div>
            @endforeach

        </div>


    </section>
</div>
