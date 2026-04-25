<?php

namespace App\Livewire\Forms;

use App\Models\Game;
use App\Models\Train;
use App\Models\User;
use App\Notifications\NewMatchNotification;
use App\Notifications\NewTrainNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateTrainForm extends Form
{


    #[Validate('required', message: 'Le champs date est requis')]
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


        $current_user = Auth::user()->getAuthIdentifier();
        $teams_id = DB::table('team')->where('user_id', $current_user)->value('id');

        $train = Train::create([
            'team_id' => $teams_id,
            'user_id' => $current_user,
            'date_train' => $this->date,
            'address' => $this->places,
            'hours_start' => $this->hours_start,
            'hours_end' => $this->hours_end,
        ]);

        $players_list = DB::table('players')
            ->where('team_id', $teams_id)
            ->pluck('user_id');
        $users = User::whereIn('users.id', $players_list)->get();


        Notification::send($users, new NewTrainNotification($train));


    }
}
