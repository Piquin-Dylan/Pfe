<?php

use Livewire\Component;

new class extends Component {
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
        //code sur le tuto
        if (Auth::user()->tutorial()->where('tutorial_name', 'dashboard')->exists()) {
            $this->showTutorial = false;
        } else {
            $this->showTutorial = true;
            \App\Models\Tutorial::create([
                'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
                'tutorial_name' => "dashboard",
                'seen' => true
            ]);
            $this->dispatch('start-dashboard-tutorial');
        }
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
