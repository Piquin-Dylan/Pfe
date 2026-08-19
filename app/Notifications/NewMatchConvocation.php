<?php

namespace App\Notifications;

use App\Models\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMatchConvocation extends Notification
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $date = \Carbon\Carbon::parse($this->match->date_match)->format('d/m/Y');

        return (new MailMessage)
            ->subject("Convocation - Match du {$date}")
            ->greeting("Bonjour {$notifiable->firstName},")
            ->line("Vous avez été sélectionné(e) pour le match du {$date} à {$this->match->hours}.")
            ->line("Adversaire : {$this->match->name_away}")
            ->line("Lieu : {$this->match->address}")
            ->action('Voir mes convocations', route('match'))
            ->line("Merci de confirmer votre présence depuis l'application.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $date = \Carbon\Carbon::parse(
            $this->match->date_match
        )->format('d/m/Y');

        return [
            'type' => 'convocation_match',
            'match_id' => $this->match->id,
            'date_match' => $this->match->date_match,
            'address' => $this->match->address,
            'hours' => $this->match->hours,
            'name_away' => $this->match->name_away,
            'message' => "Vous avez été sélectionné pour le match du {$date} à {$this->match->hours}",
        ];
    }
}
