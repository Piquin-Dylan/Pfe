<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {


    public function logout(Request $request): \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {

    }
}
?>

<div>
    @auth
        <h2>Hello {{Auth::user()->getEmailForPasswordReset()}}</h2>
    @endauth


{{--
       <button type="submit" wire:click="logout">Deconnexion</button>
--}}

</div>
