<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateEventForm extends Form
{

    public $teams;

    #[Validate('required', message: 'Le champs date est requis')]
    public string $date = "";

    #[Validate('required', message: 'Le champs lieux est requis')]
    public string $place = "";

    #[Validate('required', message: 'Le champs heure de convocation est requis')]
    public string $hours_first = "";

    #[Validate('required', message: 'Le champs heure du match est requis')]
    public string $hours_second = "";

    #[Validate('required', message: 'Le champs nom équipe a domicile est requis')]
    public string $name_home = "";

    #[Validate('required', message: "Le champs nom équipe a l'extérieur est requis domicile est requis")]
    public string $name_away = "";


    public function submit()
    {
        $this->validate();



     /*   $this->teams = Auth::user()->team()->get();
        $current_user = Auth::user()->getAuthIdentifier();
            Game::create([
                'team_id' => $this->teams,
            ]);*/

    }
}
