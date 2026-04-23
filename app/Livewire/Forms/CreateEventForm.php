<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateEventForm extends Form
{


    #[Validate('required', message: 'Le champs date est requis')]
    public string $date = "";

    #[Validate('required', message: 'Le champs lieux est requis')]
    public string $place = "";

    #[Validate('required', message: 'Le champs heure de convocation est requis')]
    public string $hours = "";

    #[Validate('required', message: 'Le champs nom équipe a domicile est requis')]
    public string $name_home = "";

    #[Validate('required', message: "Le champs nom équipe a l'extérieur est requis domicile est requis")]
    public string $name_away = "";


    public function submit(): void
    {
        $this->validate();


        $current_user = Auth::user()->getAuthIdentifier();
        $teams_id = DB::table('team')->where('user_id', $current_user)->value('id');


        Game::create([
            'team_id' => $teams_id,
            'user_id' => $current_user,
            'date_match' => $this->date,
            'address' => $this->place,
            'hours' => $this->hours,
            'name_home' => $this->name_home,
            'name_away' => $this->name_away,
        ]);


    }
}
