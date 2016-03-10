<?php
namespace App\Exceptions;

use App\Models\User;

class UserVerifiedException extends \Exception
{
    protected $user;

    /**
     * Create the exception.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}