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
    @auth
        <h2 class="subtitle_section">Hello {{Auth::user()->getEmailForPasswordReset()}}</h2>
    @endauth
    @foreach($this->teams as $team)
        <h2 class="subtitle_section">{{$team->name}}</h2>
    @endforeach

    <form wire:submit="logout" method="POST">
        <button class="subtitle_section" type="submit">Deconnexion</button>
    </form>

</div>
