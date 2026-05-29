<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use Livewire\Component;

new class extends Component {
    public \Illuminate\Support\Collection $trains;

    public \Illuminate\Support\Collection $game;

    public function mount(): void
    {

        $current_user = Auth::user()->id;


        if (Auth::user()->player) {
            $player = Player::where('user_id', $current_user)->select('team_id')->value('team_id');
            $this->trains = Train::where('team_id', $player)->orderby('date_train', 'asc')->get();
        } else {
            $team = Team::where('user_id', $current_user)->select('id')->value('id');
            $this->trains = Train::where('team_id', $team)->orderby('date_train', 'asc')->get();
        }
    }

    public function deleteEvent($id, $type): void
    {
        if ($type === '') {
            Train::where('id', $id)->delete();
            Game::where('id', $id)->delete();

        }

        $this->dispatch('event-deleted', id: $id);
    }

    public function updateEvent()
    {
        Train::where('id', $id)->update();
        Game::where('id', $id)->update();

    }
};
?>

<div>
    <div class="flex flex-col flex-wrap gap-4 justify-center items-center sm:flex-row">
        <livewire:admin.create_event></livewire:admin.create_event>
        <livewire:admin.create_train></livewire:admin.create_train>
    </div>
    <div wire:ignore>
        <x-calendar-test></x-calendar-test>
    </div>
    <x-dialog_modal></x-dialog_modal>

</div>
