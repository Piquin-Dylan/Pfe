<?php

namespace App\Notifications;

use App\Models\Player;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ParticipationResponseNotification extends Notification
{
    use Queueable;

    public $type;
    public $string;
    public $playerId;
    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $string, $playerId, $event)
    {
        $this->type = $type;
        $this->string = $string;
        $this->playerId = Player::find($playerId)->firstName;
        $this->event = $event;
    }

    /**
     * Get the notification delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $date = $this->type === 'match'
            ? \Carbon\Carbon::parse($this->event->date_match)->format('d/m/Y')
            : \Carbon\Carbon::parse($this->event->date_train)->format('d/m/Y');

        return [
            'type' => $this->type,
            'message' => "Le joueur " . $this->playerId . " est " . $this->string . " pour le " . $this->type . " du " . $date,
            'notification_type' => "participation_response",
        ];
    }
}
