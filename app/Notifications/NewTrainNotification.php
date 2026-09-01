<?php

namespace App\Notifications;

use App\Models\Train;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

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
        if (app()->runningInConsole()) {
            return ['database'];
        }

        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $date = \Carbon\Carbon::parse($this->train->date_train)->format('d/m/Y');
        $expiresAt = \Carbon\Carbon::parse($this->train->date_train)->endOfDay();

        $presentUrl = URL::temporarySignedRoute('convocation.train.respond', $expiresAt, [
            'train' => $this->train->uuid,
            'player' => $notifiable->player->id,
            'status' => 'present',
        ]);

        $absentUrl = URL::temporarySignedRoute('convocation.train.respond', $expiresAt, [
            'train' => $this->train->uuid,
            'player' => $notifiable->player->id,
            'status' => 'absent',
        ]);

        return (new MailMessage)
            ->subject("Convocation - Entraînement du {$date}")
            ->greeting("Bonjour {$notifiable->firstName},")
            ->line("Un entraînement a été programmé le {$date} de {$this->train->hours_start} à {$this->train->hours_end}.")
            ->line("Lieu : {$this->train->address}")
            ->action('✅ Je suis présent(e)', $presentUrl)
            ->line("Vous ne pourrez pas venir ? [Cliquez ici pour signaler votre absence]({$absentUrl}).");
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
