<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nickname', 'gender', 'birthday', 'cell_number', 'dominant_hand', 'height', 'division_preference_first', 'division_preference_second', 'image', 'admin', 'season_pass_ends_on', 'ip_address', 'last_login',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set the user's email as confirmed
     *
     * @return bool
     */
    public function confirmEmailAddress()
    {
        // Set the confirmed flag to true
        $this->confirmed = 1;

        // Remove the confirmation code
        $this->confirmation_code = null;

        return $this->save();
    }
}
