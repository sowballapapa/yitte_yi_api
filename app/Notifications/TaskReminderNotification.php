<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Task $task,
        public readonly User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $dueFormatted = \Carbon\Carbon::parse($this->task->due_datetime)
            ->setTimezone($this->user->preferences?->timezone ?? 'Africa/Dakar')
            ->translatedFormat('l d F Y à H\hi');

        return (new MailMessage)
            ->subject("⏰ Rappel : {$this->task->title}")
            ->greeting("Bonjour {$this->user->name} !")
            ->line("Votre tâche **{$this->task->title}** arrive à échéance prochainement.")
            ->line("📅 **Échéance** : {$dueFormatted}")
            ->when($this->task->content, fn($mail) => $mail->line("📝 **Description** : {$this->task->content}"))
            ->action('Voir la tâche', env('MOBILE_APP_URL_SCHEME', 'yitte://') . 'tasks/' . $this->task->id)
            ->line('Pensez à la marquer comme terminée une fois accomplie.')
            ->salutation('L\'équipe Yitte Yi');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'task_reminder',
            'task_id' => $this->task->id,
            'user_id' => $this->user->id,
        ];
    }
}
