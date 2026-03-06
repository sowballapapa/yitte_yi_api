<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bienvenue sur Yitte Yi ! 🎉')
            ->greeting("Bonjour {$this->user->name} !")
            ->line('Votre compte a été créé avec succès. Nous sommes ravis de vous accueillir sur **Yitte Yi**.')
            ->line('Avec Yitte Yi, organisez vos tâches, gérez vos priorités et restez productif au quotidien.')
            ->action('Commencer maintenant', env('MOBILE_APP_URL_SCHEME', 'yitte://') . 'home')
            ->line('Si vous avez des questions, notre équipe est disponible pour vous aider.')
            ->salutation('L\'équipe Yitte Yi');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'type'    => 'welcome',
        ];
    }
}
