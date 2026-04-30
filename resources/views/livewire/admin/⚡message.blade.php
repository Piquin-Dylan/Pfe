<?php

use App\Models\Player;
use App\Models\Train;
use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $notifications;
    public string $status = "";

    public function mount(): void
    {
        $user = Auth::user();

        $this->notifications = $user->notifications;

    }

    public function changeStatus($string, $train_id): void
    {
        $current_user = Auth::user()->getAuthIdentifier();

        $playerId = Player::where('user_id', $current_user)->select('id')->value('id');

        $train = Train::find($train_id);


        //on update dans la table pivot la colonnes status en la passant de pending a présent ou absent selon sur quoi l'utilisateur clique
        $train->players()->updateExistingPivot($playerId, [
            'status' => $string
        ]);
    }
};
?>

<div>
    <h2 class=" mt-4 mb-4  title_section  lg:mt-12 lg:mb-4">Messages</h2>
    <section class="ml-6 mr-6  lg:items-center lg:flex-col ">

        @foreach($notifications as $notification)

            <div
                class="flex items-center mt-6 mb-6 flex-col min-w-full  justify-between bg-gradient-to-r from-[#1E293B] to-[#0F172A] border border-white rounded-2xl p-5 w-full max-w-3xl shadow-lg">
                <span class="text-white lg:text-2xl"> {{ $notification->data['message'] ?? "" }} </span>
                <div class="mt-4 flex gap-6">
                        <span
                            wire:click="changeStatus('present',{{ $notification->data['train_id'] ?? ""}})">Présent</span>
                    <span
                        wire:click="changeStatus('absent',{{ $notification->data['train_id'] ?? ""}})">Absent</span>

                </div>
            </div>

        @endforeach
    </section>
</div>

