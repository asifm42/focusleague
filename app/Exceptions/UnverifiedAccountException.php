<?php
namespace App\Exceptions;

use App\Models\User;

class UnverifiedAccountException extends \Exception
{
    /**
     * The user instance
     *
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the user instance
     *
     */
    public function user() {
        return $this->user;
    }
}