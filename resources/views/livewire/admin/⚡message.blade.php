<?php

use App\Models\Game;
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

    public function changeStatus($string, $type, $id): void
    {
        $current_user = Auth::user()->getAuthIdentifier();

        $playerId = Player::where('user_id', $current_user)
            ->value('id');


        if ($type === 'train') {
            $train = Train::findOrFail($id);
            //$this->notifications->markAsRead();
            $train->players()->updateExistingPivot($playerId, [
                'status' => $string,
            ]);
        } else {
            $match = Game::findOrFail($id);
           // $this->notifications->markAsRead();
            $match->players()->updateExistingPivot($playerId, [
                'status' => $string,
            ]);
        }
    }
};
?>

<div>
    <h2 class="mt-4 mb-4 title_section lg:mt-12 lg:mb-4">Messages</h2>

    <section class="ml-6 mr-6 lg:items-center lg:flex-col">
        @foreach($notifications as $notification)

            @php
                if (isset($notification->data['train_id'])) {
                    $type = 'train';
                    $id = $notification->data['train_id'];
                } else {
                    $type = 'match';
                    $id = $notification->data['match_id'];
                }
            @endphp

            <div
                    class="relative mx-6 mb-8 bg-gradient-to-br from-[#0f172a] to-[#020617] border border-blue-500/40 rounded-2xl p-6 flex flex-col gap-5 text-white transition hover:translate-y-[-2px] hover:border-blue-400/60 max-w-3xl w-full"
            >

                <div class="absolute top-4 right-4 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">
                        @if($notification->read_at === null)
                            Non lu
                        @else
                            Lu
                        @endif
                    </span>
                </div>

                <div class="text-lg lg:text-xl font-semibold tracking-wide pr-24">
                    {{ $notification->data['message'] ?? '' }}
                </div>

                <div class="flex gap-4">
                    <button
                            wire:click="changeStatus('present', '{{ $type }}', {{ $id }})"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold transition hover:scale-[1.03] hover:brightness-110"
                    >
                        Présent
                    </button>

                    <button
                            wire:click="changeStatus('absent', '{{ $type }}', {{ $id }})"
                            class="px-5 py-2.5 bg-white/5 border border-white/10 text-gray-300 text-sm font-semibold rounded-xl transition hover:bg-white/10 hover:text-white"
                    >
                        Absent
                    </button>
                </div>
            </div>
        @endforeach
    </section>
</div>
