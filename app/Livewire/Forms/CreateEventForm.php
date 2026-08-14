<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use App\Models\User;
use App\Notifications\NewMatchNotification;

use Illuminate\Support\Facades\Auth;
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

    #[Validate('required', message: "Le champs nom équipe a l'extérieur est requis domicile est requis")]
    public string $name_away = "";

    #[Validate('required|image|max:2048')]
    public $photo_away = "";

    public function submit(): void
    {
        $this->validate();

        $photoAwayPath = $this->photo_away->store('photos', 'public');

        $team = Auth::user()->currentTeam();

        $match = Game::create([
            'team_id' => $team->id,
            'user_id' => Auth::id(),
            'date_match' => $this->date,
            'address' => $this->place,
            'hours' => $this->hours,
            'name_away' => $this->name_away,
            'photo_away' => $photoAwayPath,
        ]);

        $users = User::whereIn('id', $team->players()->pluck('user_id'))->get();

        Notification::send($users, new NewMatchNotification($match));
    }


}
