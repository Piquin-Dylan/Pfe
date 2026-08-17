<?php

namespace App\Livewire\Forms;

use App\Models\Train;
use App\Models\User;
use App\Notifications\NewTrainNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateTrainForm extends Form
{


    #[Validate('required', message: 'Le champs date est requis')]
    #[Validate('after_or_equal:today', message: "La date de l'entraînement ne peut pas être dans le passé")]
    public string $date = "";

    #[Validate('required', message: 'Le champs lieux  est requis')]
    public string $places = "";

    #[Validate('required', message: 'Le champs heure de début est requis')]
    public string $hours_start = "";

    #[Validate('required', message: 'Le champs heure de fin  est requis')]
    public string $hours_end = "";


    public function submit(): void
    {
        $this->validate();

        $team = Auth::user()->currentTeam();

        $train = Train::create([
            'team_id' => $team->id,
            'user_id' => Auth::id(),
            'date_train' => $this->date,
            'address' => $this->places,
            'hours_start' => $this->hours_start,
            'hours_end' => $this->hours_end,
        ]);

        $players = $team->players;

        //De la ligne 61 a la ligne 68 se code permet de gérer le fait quand un événement entrainement est créer sa ajoute dans la table pivot le train_id le player_id ainsi que le status
        $players_array = [];

        foreach ($players as $player) {
            $players_array[$player->id] = ['status' => 'en attente'];
        }

        $train->players()->attach($players_array);

        $users = User::whereIn('id', $players->pluck('user_id'))->get();

        Notification::send($users, new NewTrainNotification($train));
    }
}
