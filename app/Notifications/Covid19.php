<?php

namespace App\Notifications;

use App\Models\Week;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Covid19 extends Notification
{
    use Queueable;

    protected $week;
    protected $nextWeek;
    protected $name;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Week $week, Week $nextWeek, $name)
    {
        $this->week = $week;
        $this->nextWeek = $nextWeek;
        $this->name = $name;
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
                ->subject('COVID-19 Cancelation Credit')
                ->greeting('Hi ' . $this->name . ',')
                    ->line('Cycle ' . $this->week->cycle->name . ' Wk ' . $this->week->index() . ' & ' . ' Wk ' . $this->nextWeek->index() . ' have been canceled. The 2020 season is on pause due to the social distancing guidelines in response to COVID-19. A $5 credit has been added to your account for each of the canceled nights you signed up for.')
                    ->line('We will assess the dynamic situation next week to determine Cycle 2020-02\'s status.');
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
