<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for the FOCUS League account associated with this email address.')
            ->line('If this was you, please start the reset process by clicking the link below. Please note this link will expire in 60 minutes.')
            ->action('Reset Password', url('password/reset', $this->token))
            ->line('If you did not request a password reset, then please disregard this email; no further action is required.');

        if (isset($notifiable->name)) {
            if ((strpos($notifiable->name, ' '))) {
                $mailMessage->greeting('Hi ' . strstr($notifiable->name, ' ', true) . ',');
            } else {
                $mailMessage->greeting('Hi ' . $notifiable->name . ',');
            }
        }

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
