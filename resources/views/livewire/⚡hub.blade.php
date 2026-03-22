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
}
?>

<div>
    @auth
        <h2>Hello {{Auth::user()->getEmailForPasswordReset()}}</h2>
    @endauth


    <form wire:submit="logout" method="POST">
        <button type="submit">Deconnexion</button>
    </form>

</div>
