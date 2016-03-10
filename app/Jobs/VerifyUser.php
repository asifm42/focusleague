<?php

namespace App\Jobs;

use Auth;
use App\Events\UserVerified;
use App\Exceptions\InvalidConfirmationCodeException;
use App\Jobs\Job;
use App\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class VerifyUser extends Job implements SelfHandling
{

    protected $confirmationCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($confirmation_code)
    {
        $this->confirmationCode = $confirmation_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::whereConfirmationCode($this->confirmationCode)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        // Set the user's email as confirmed
        $user->confirmEmailAddress();

        event(new UserVerified($user));
    }
}
