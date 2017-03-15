<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $firstName = strstr($notifiable->name, ' ', true);
        if ((strpos($notifiable->name, ' '))) {
            $firstName = strstr($notifiable->name, ' ', true);
        } else {
            $firstName = $notifiable->name;
        }

        $mailMessage = (new MailMessage)
            ->greeting('Hi ' . $firstName . ',')
            ->subject('FOCUS League - Verify your email')
            ->line('Well, we hope this is ' . $firstName . '. Someone registered an account at focusleague.com using the name, ' . $notifiable->name . ' and email, '. $notifiable->email . '.')
            ->line('If this was you, please verify your email address by clicking the button below. We will be communicating most league information via email and it is important that we have an accurate email address.')
            ->action('VERIFY EMAIL ADDRESS', url('users/verify', $notifiable->confirmation_code))
            ->line('If you did not register for an FOCUS League account, then please disregard this email; no further action is required.');

        return $mailMessage;
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
