<?php

namespace App\Notifications;

use App\Models\Game;
use App\Models\Train;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMatchNotification extends Notification
{
    use Queueable;

    public Game $match;

    /**
     * Create a new notification instance.
     */
    public function __construct(Game $match)
    {
        $this->match = $match;
    }

    /**
     * Get the notification's delivery channels.
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
        return [
            'type' => 'match_created',
            'match_id' => $this->match->id,
            'date_match' => $this->match->date_match,
            'address' => $this->match->address,
            'hours' => $this->match->hours,
            'name_home' => $this->match->name_home,
            'name_away' => $this->match->name_away,
            'message' => "L'entraîneur a créé un match pour  le {$this->match->date_train} à {$this->match->hours_start}"];
    }


}
