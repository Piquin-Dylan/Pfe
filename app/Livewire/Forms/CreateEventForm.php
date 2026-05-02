<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use App\Models\User;
use App\Notifications\NewMatchNotification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateEventForm extends Form
{
    use WithFileUploads;


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


    #[Validate('required|image', message: 'Le champs photo a domicile est requis')]
    public $photo_home = "";


    #[Validate('required|image', message: "Le champs photo a l'extérieur est requis")]
    public $photo_away = "";

    public function submit(): void
    {
        $this->validate();

        $photoHomePath = $this->photo_home->store('photos', 'public');
        $photoAwayPath = $this->photo_away->store('photos', 'public');

        $current_user = Auth::user()->getAuthIdentifier();
        $teams_id = DB::table('team')->where('user_id', $current_user)->value('id');

        $match = Game::create([
            'team_id' => $teams_id,
            'user_id' => $current_user,
            'date_match' => $this->date,
            'address' => $this->place,
            'hours' => $this->hours,
            'name_home' => $this->name_home,
            'name_away' => $this->name_away,
            'photo_home' => $photoHomePath,
            'photo_away' => $photoAwayPath,
        ]);

        $players_list = DB::table('players')
            ->where('team_id', $teams_id)
            ->pluck('user_id');
        $users = User::whereIn('users.id', $players_list)->get();


        Notification::send($users, new NewMatchNotification($match));
    }


}
