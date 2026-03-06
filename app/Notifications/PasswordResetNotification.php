<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $token,
        public readonly string $email
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Deep-link for mobile app or web URL
        $resetUrl = env('MOBILE_APP_URL_SCHEME', 'yitte://') . 'reset-password?token=' . $this->token . '&email=' . urlencode($this->email);

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour !')
            ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->action('Réinitialiser le mot de passe', $resetUrl)
            ->line('Ce lien de réinitialisation expirera dans **60 minutes**.')
            ->line("Si vous n'avez pas demandé de réinitialisation, vous pouvez ignorer cet e-mail en toute sécurité.")
            ->salutation('L\'équipe Yitte Yi');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'  => 'password_reset',
            'email' => $this->email,
        ];
    }
}
