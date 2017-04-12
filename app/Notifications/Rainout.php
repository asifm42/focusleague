<?php

namespace App\Notifications;

use App\Models\Week;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Rainout extends Notification
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
                ->subject('Game OFF - Rainout')
                ->greeting('Game OFF')
                    ->line('Cycle ' . $this->week->cycle->name . ' Wk ' . $this->week->index() . ' has been rained out. A rainout credit will be added to your account.')
                    ->line('We hope to see you next week.');
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
