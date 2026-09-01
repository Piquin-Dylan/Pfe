<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-team', fn (User $user) => $user->team !== null);

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe')
                ->greeting("Bonjour {$notifiable->firstName},")
                ->line("Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.")
                ->action('Réinitialiser le mot de passe', $url)
                ->line('Ce lien expirera dans 60 minutes.')
                ->line("Si vous n'êtes pas à l'origine de cette demande, aucune action n'est requise.");
        });
    }
}
