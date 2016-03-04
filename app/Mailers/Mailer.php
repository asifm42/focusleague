<?php

namespace App\Mailers;

use Mail;

abstract class Mailer
{
    /**
     * Queue the email.
     *
     * @return void
     */
    public function sendTo($user, $subject, $view, $data = [], $headers = [])
    {
        // change to "Mail::queue" when ready to use queues
        Mail::queue($view, $data, function($message) use($user, $subject, $headers)
        {
            $message->from('support@focusleague.com', 'FOCUS League')
                    ->to($user->email)
                    ->subject($subject);

            if (array_key_exists ( 'x-mailgun-tag' , $headers )) {
                $swiftMessage = $message->getSwiftMessage();

                $mailHeaders = $swiftMessage->getHeaders();
                $mailHeaders->addTextHeader('x-mailgun-tag', $headers['x-mailgun-tag']);
            }
        });
    }

}