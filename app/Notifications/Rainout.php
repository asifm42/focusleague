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
        $msg = 'Cycle ' . $this->week->cycle->name . ' Wk ' . $this->week->index() . ' has been canceled due to weather.';

        if ($notifiable->isCaptain($this->week->cycle)) {
            $msg += ' A $3.75 rainout credit will be added to your account.';
        } else if ($this->week->players()->contains($notifiable)) {
            $msg += ' A $' . config('focus.cost.rainout_credit') . ' rainout credit will be added to your account.';
        } else if ($this->week->subsOnATeam->contains($notifiable)){
            $msg += ' A $' . config('focus.cost.sub') . ' rainout credit will be added to your account.';
        } else {
            $msg = ' A rainout credit may be added to your account.';
        }

        return (new MailMessage)
                ->subject('Game OFF - Rainout')
                ->greeting('Game OFF')
                    ->line($msg)
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
