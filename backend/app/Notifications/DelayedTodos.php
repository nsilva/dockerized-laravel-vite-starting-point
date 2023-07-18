<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DelayedTodos extends Notification implements ShouldQueue
{
    use Queueable;

    private int $delayedTodos;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $delayedTodos)
    {
        $this->delayedTodos = $delayedTodos;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $tasksString = ($this->delayedTodos == 1) ? 'task' : 'tasks';
        return (new MailMessage)
                    ->line("You have {$this->delayedTodos} {$tasksString} in progress for more than 24 hrs.")
                    ->line("Visit the ToDoist application to update your tasks.")
                    ->action('ToDoist Application', url('/'))
                    ->line('Thank you for using ToDoist!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
