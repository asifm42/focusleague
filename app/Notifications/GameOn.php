<?php

namespace App\Notifications;

use App\Models\Week;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GameOn extends Notification
{
    use Queueable;

    protected $week;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Week $week)
    {
        $this->week = $week;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject('Game ON')
                ->greeting('Game ON - Cycle ' . $this->week->cycle->name . ' Wk ' . $this->week->index() . '.')
                ->line('We see that your signed up to play tonight. Awesome! But if your plans have changed and you can\'t make it tonight, please let us know by replying to this email. Otherwise, we\'ll see you tonight!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
