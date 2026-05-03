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

            <div class="mx-6 mb-8 bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white/10 rounded-2xl p-6 flex flex-col gap-5 text-white transition hover:translate-y-[-2px] hover:border-white/20 max-w-3xl w-full">

                <div class="text-lg lg:text-xl font-semibold tracking-wide">
                    {{ $notification->data['message'] ?? "" }}
                </div>

                <div class="flex gap-4">
                    <button
                        wire:click="changeStatus('present',{{ $notification->data['train_id'] ?? ""}})"
                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold transition hover:scale-[1.03] hover:brightness-110">
                        Présent
                    </button>

                    <button
                        wire:click="changeStatus('absent',{{ $notification->data['train_id'] ?? ""}})"
                        class="px-5 py-2.5  bg-white/5 border border-white/10 text-gray-300 text-sm font-semibold rounded-xl transition hover:bg-white/10 hover:text-white">
                        Absent
                    </button>
                </div>

            </div>

        @endforeach
    </section>
</div>

