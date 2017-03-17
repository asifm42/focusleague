<?php

namespace App\Mail\Alert;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $msg;
    public $timestamp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $msg)
    {
        $this->name = $name;
        $this->email = $email;
        $this->msg = $msg;
        $this->timestamp = Carbon::now()->toDayDateTimeString();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, $this->name)
                ->to('asifm42@gmail.com', 'Asif Mohammed')
                ->cc('gizmolito@gmail.com', 'Nick Carranza')
                ->subject('FOCUS League Contact us page')
                ->text('emails.alert.contact');
    }
}
