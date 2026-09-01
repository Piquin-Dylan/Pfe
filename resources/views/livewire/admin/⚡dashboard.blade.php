<?php

use App\Livewire\Concerns\HandlesTutorial;
use Livewire\Component;

new class extends Component {

    use HandlesTutorial;

    public string $tutorial = 'dashboard';

    public function logout(\Illuminate\Http\Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function mount()
    {
        $this->initializeTutorial('dashboard', 'start-dashboard-tutorial');
    }
};
?>

<div>

{{--
    <span class="text-white flex justify-center">{{Auth::user()->firstName}}</span>
--}}
    <form class="flex justify-center" wire:submit="logout" method="POST">
        <button id="test" class="btn_deconnexion" type="submit">Deconnexion</button>
    </form>
</div>
