<?php

use Livewire\Component;

new class extends Component {


    //Permet de pouvoir déconnecter un utilisateur qui est sur le hub en appuyant sur le bouton deconnexion
    public function logout(): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        return redirect('/hub');
    }
};
?>

<div>

    <h1 class="text-white flex justify-center">Bonjour coach {{Auth::user()->firstName}}</h1>
    <form class="flex justify-center" wire:submit="logout" method="POST">
        <button class="btn_deconnexion" type="submit">Deconnexion</button>
    </form>



</div>
