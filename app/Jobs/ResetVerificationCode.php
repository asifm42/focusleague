<?php

namespace App\Jobs;

use App\Events\VerificationCodeReset;
use App\Exceptions\SaveModelException;
use App\Exceptions\UserVerifiedException;
use App\Jobs\Job;
use App\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResetVerificationCode extends Job implements SelfHandling
{

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::whereEmail($this->email)->first();

        if ( ! $user) {
            throw new ModelNotFoundException;
        }

        if ($user->confirmed === 1) {
            throw new UserVerifiedException($user);
        }

        $user['confirmation_code'] = str_random(32);

        if ( ! $user->save())
            throw new SaveModelException($user);

        event(new VerificationCodeReset($user));
    }
}
