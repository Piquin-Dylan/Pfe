<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Train;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $notifications;
    public string $status = "";

    public function mount(): void
    {
        $user = Auth::user();

        $this->notifications = $user->notifications;

        foreach ($this->notifications as $notification) {
            if (isset($notification->data["notification_type"])) {
                $notification->markAsRead();
            }
        }
    }

    public function changeStatus($string, $type, $id, $notificationId): void
    {
        $current_user = Auth::user()->getAuthIdentifier();

        $playerId = Player::where('user_id', $current_user)
            ->value('id');


        if ($type === 'train') {
            $train = Train::findOrFail($id);
            $train_coach = Train::findOrFail($id)->team->user;
            DatabaseNotification::find($notificationId)->markAsRead();

            $train->players()->updateExistingPivot($playerId, [
                'status' => $string,
            ]);
            $train_coach->notify(new \App\Notifications\ParticipationResponseNotification($type, $string, $playerId, $train));


        } else {
            $match = Game::findOrFail($id);
            $match_coach = Game::findOrFail($id)->team->user;
            DatabaseNotification::find($notificationId)->markAsRead();
            $match->players()->updateExistingPivot($playerId, [
                'status' => $string,
            ]);

            $match_coach->notify(new \App\Notifications\ParticipationResponseNotification($type, $string, $playerId, $match));
        }
    }
};
?>

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white">Messages</h2>
            <p class="text-gray-400 mt-1">
                Convocations, entraînements et messages de l'équipe.
            </p>
        </div>

        @livewire('communication-form')
    </div>

    @if($notifications->isEmpty())
        <div class="max-w-2xl mx-auto mt-10 p-6 sm:p-8 rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-xl sm:text-2xl font-bold text-white mb-3">
                Aucun message pour le moment
            </h3>

            <p class="text-sm sm:text-base text-gray-300">
                Les convocations, créations d'entraînement et messages de l'équipe apparaîtront ici.
            </p>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach($notifications as $notification)

                @php
                    $data = $notification->data;
                    $isInfo = isset($data['notification_type']);
                    $type = isset($data['train_id']) ? 'train' : 'match';
                    $eventId = $data['train_id'] ?? $data['match_id'] ?? null;

                    $accent = match(true) {
                        isset($data['train_id']) => ['bar' => 'bg-green-500', 'icon' => '🏃'],
                        ($data['notification_type'] ?? null) === 'participation_response' => ['bar' => 'bg-gray-400', 'icon' => '👤'],
                        $isInfo => ['bar' => 'bg-violet-500', 'icon' => '📣'],
                        default => ['bar' => 'bg-red-500', 'icon' => '⚽'],
                    };
                @endphp

                <div
                    @class([
                        'relative flex gap-4 rounded-2xl border p-5 sm:p-6 transition hover:border-violet-400/40',
                        'border-white/10 bg-white/[0.03]' => $notification->read_at,
                        'border-violet-500/30 bg-gradient-to-br from-[#171b34] to-[#0b0e1d]' => !$notification->read_at,
                    ])>

                    <span class="w-1 rounded-full {{ $accent['bar'] }} shrink-0"></span>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4 mb-2">
                            <span class="text-xl leading-none">{{ $accent['icon'] }}</span>

                            <div class="flex items-center gap-2 shrink-0">
                                @unless($notification->read_at)
                                    <span class="w-2 h-2 rounded-full bg-violet-400"></span>
                                @endunless
                                <span class="text-xs text-gray-400 whitespace-nowrap">
                                    {{ $notification->created_at->locale('fr')->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <p class="text-white text-base sm:text-lg leading-snug break-words">
                            {{ $data['message'] ?? '' }}
                        </p>

                        @unless($isInfo)
                            <div class="flex gap-3 mt-4">
                                <button
                                    wire:click="changeStatus('present', '{{ $type }}', {{ $eventId }},'{{ $notification->id }}')"
                                    class="px-5 py-2 rounded-xl bg-green-500/20 text-green-400 border border-green-500/40 text-sm font-semibold transition hover:bg-green-500/30 cursor-pointer">
                                    Présent
                                </button>

                                <button
                                    wire:click="changeStatus('absent', '{{ $type }}', {{ $eventId }},'{{ $notification->id }}')"
                                    class="px-5 py-2 rounded-xl bg-red-500/20 text-red-400 border border-red-500/40 text-sm font-semibold transition hover:bg-red-500/30 cursor-pointer">
                                    Absent
                                </button>
                            </div>
                        @endunless
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
