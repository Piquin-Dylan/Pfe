<?php

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

new class extends Component {


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/connexion');
    }

    public function mount(): void
    {
        //on récupére les équipes de l'utilisateur actuellement connecter
        $this->teams = Auth::user()->team()->get();


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
                <form wire:submit="logout" method="POST">
                    <button class="btn_deconnexion" type="submit">Deconnexion</button>
                </form>
                <span class="title_section">Mes équipes</span>
            </div>
        @endauth

        <div class="lg:flex lg:flex-row">
        @foreach($this->teams as $team)
            <div class=" card_hub flex items-center flex-col gap-8 flex-wrap ">

                <span class="text-white">{{$team->name}}</span>
                <span class="text-white">{{$team->division}}</span>
                <span class="text-white">{{$team->ville}}</span>
                <span class="text-white">{{$team->code}}</span>
            </div>
        @endforeach
        </div>

    </section>
</div>
