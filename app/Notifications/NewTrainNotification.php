<?php

namespace App\Notifications;

use App\Models\Game;
use App\Models\Train;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTrainNotification extends Notification
{
    use Queueable;

    public Train $train;

    /**
     * Create a new notification instance.
     */
    public function __construct(Train $train)
    {
        $this->train = $train;
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
            'type' => 'train_created',
            'train_id' => $this->train->id,
            'date_train' => $this->train->date_train,
            'address' => $this->train->address,
            'hours_start' => $this->train->hours_start,
            'hours_end' => $this->train->hours_end,
            'message' => "L'entraîneur a créé un entraînement le " .
                \Carbon\Carbon::parse($this->train->date_train)->format('d/m/Y') .
                " à {$this->train->hours_start} jusque {$this->train->hours_end}"
        ];
    }
}
