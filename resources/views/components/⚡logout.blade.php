<?php

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


new class extends Component {
    //Permet de pouvoir déconnecter un utilisateur qui est sur le hub en appuyant sur le bouton deconnexion
    public function logout(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
};
?>

<div>
        <form wire:submit="logout" method="POST">
            <button class="btn_deconnexion" type="submit">
                Déconnexion
            </button>
        </form>
</div>
