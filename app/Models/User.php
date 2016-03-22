<?php

namespace App\Models;

use App\Traits\TrimScalarValues;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use TrimScalarValues, SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['season_pass_ends_on', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'gender', 'birthday', 'cell_number', 'mobile_carrier', 'dominant_hand', 'height', 'division_preference_first', 'division_preference_second', 'image', 'admin', 'season_pass_ends_on', 'ip_address', 'last_login',
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
     * Get the user's birthday.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthdayAttribute($value)
    {
        $originalDate = $value;
        return date("m-d-Y", strtotime($originalDate));
    }

    /**
     * Set the user's birthday.
     *
     * @param  string  $value
     * @return string
     */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = date("Y-m-d", strtotime($value));
    }

    /**
     * Get the user's birthday.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthdayString()
    {
        $originalDate = $this->attributes['birthday'];
        return date("M j, Y", strtotime($originalDate));
    }

    /**
     * Get the user's phone number.
     *
     * @param  string  $value
     * @return string
     */
    public function getCellNumberAttribute($value)
    {
        // add the dashes
        return preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $value);
    }

    /**
     * Set the user's phone number.
     *
     * @param  string  $value
     * @return string
     */
    public function setCellNumberAttribute($value)
    {
        // sanitize the cell number
        $numbers_only = preg_replace("/[^\d]/", "", $value);
        $this->attributes['cell_number'] =  preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $numbers_only);
    }

    /**
     * Get the user's gender.
     *
     * @param  string  $value
     * @return string
     */
    public function getGenderAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the user's dominant hand.
     *
     * @param  string  $value
     * @return string
     */
    public function getDominantHandAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the user's first division preference.
     *
     * @param  string  $value
     * @return string
     */
    public function getDivisionPreferenceFirstAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the user's second division preference.
     *
     * @param  string  $value
     * @return string
     */
    public function getDivisionPreferenceSecondAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Get the user's nickname. If not provided, give the first name.
     *
     * @param  null
     * @return string
     */
    public function getNicknameOrFirstName()
    {
        if(!empty($this->nickname)){
            return $this->nickname;
        } elseif (strstr($this->name, ' ', true)) {
            return strstr($this->name, ' ', true);
        } else {
            return $this->name;
        }
    }

    /**
     * Get the user's nickname. If not provided, give the first name + the last 3 letters of the last name.
     *
     * @param  null
     * @return string
     */
    public function getNicknameOrShortName()
    {
        if(!empty($this->nickname)){
            return $this->nickname;
        } elseif (strstr($this->name, ' ', true)) {
            $pieces = explode(' ', $this->name);
            $letters = str_split($pieces[1], 3);
            return ucfirst($pieces[0]) . (ucfirst($letters[0]));
        } else {
            return $this->name;
        }
    }

    /**
     * Get the user's first name.
     *
     * @param  null
     * @return string
     */
    public function getFirstName()
    {
        return strstr($this->name, ' ', true);
    }

    /**
     * Get the height as a formatted string.
     *
     * @return string
     */
    public function heightString()
    {
        return floor($this->height / 12) . "' " . $this->height % 12 . '"';
    }

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

    /**
     * Get the posts the user has posted
     */
    public function posts()
    {
        return $this->hasMany('App\Models\User', 'posted_by');
    }

    /**
     * Get the cycles the user has signed up for
     */
    public function cycles()
    {
        return $this->belongsToMany('App\Models\Cycle')
                    ->withPivot('id','div_pref_first', 'div_pref_second', 'note', 'team_id', 'captain', 'will_captain')
                    ->whereNull('cycle_user.deleted_at') // for soft deletes
                ->withTimestamps();
    }

    /**
     * Get the user's current signup details
     */
    public function current_cycle_signup()
    {
        // doesn't look like we can load here
        // return $this->cycles()->current()->first()->load('signups', 'weeks', 'weeks.subs','signups.availability', 'teams');

        return $this->cycles()->current()->first();
    }

    /**
     * Get all the teams the user has been placed on
     */
    public function teams()
    {
        // The following is returning all teams for the cycle. NOT the team the user is on.
        // return $this->hasManyThrough('App\Models\Team', 'App\Models\CycleSignup', 'team_id', 'id');
    }

    /**
     * Get the weeks the user has signed up for
     */
    public function availability()
    {
        return $this->belongsToMany('App\Models\Week', 'availability')
                    ->withPivot('attending')
                    ->orderBy('pivot_week_id')
                    ->withTimestamps();
    }


    /**
     * Get the weeks the user has signed up for as sub
     */
    public function subs()
    {
        return $this->hasMany('App\Models\Sub')
                    ->orderBy('week_id')
                    ->withTimestamps();
    }
    /**
     * Get the user's transactions
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction')
                    ->orderBy('date')->orderBy('created_at');
    }

    /**
     * Get the user's charges
     */
    public function charges()
    {
        return $this->transactions()->ofType('charge');
    }

    /**
     * Get the user's payments
     */
    public function payments()
    {
        return $this->transactions()->ofType('payment');
    }

    /**
     * Get the user's credits
     */
    public function credits()
    {
        return $this->transactions()->ofType('credit');
    }

    /**
     * Get the user's balance
     */
    public function getBalance()
    {
        $balance = 0;

        foreach ($this->transactions as $transaction){
            switch($transaction->type){
                case 'charge':
                    $balance += $transaction->amount;
                    break;
                case 'payment':
                case 'fee':
                    $balance -= $transaction->amount;
                    break;

            }
        }

        return $balance;
    }

    /**
     * Get the user's balance as a string with dollar sign
     */
    public function getBalanceString()
    {
        $balance = $this->getBalance();

        if ( $balance < 0 ) {
            $balanceStr = '-$' . abs($balance);
        } else {
            $balanceStr = '$' . $balance;
        }

        return $balanceStr;
    }

    /**
     * Get the user's ultimate history
     */
    public function ultimateHistory()
    {
        return $this->hasOne('App\Models\UltimateHistory');
    }

    /**
     * Scope a query to only male users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }

    /**
     * Scope a query to only female users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFemale($query)
    {
        return $query->where('gender', 'female');
    }

    /**
     * Checks if the user is male.
     *
     * @return bool
     */
    public function isMale()
    {
        return strtolower($this->gender) === 'male';
    }

    /**
     * Checks if the user is female.
     *
     * @return bool
     */
    public function isFemale()
    {
        return strtolower($this->gender) === 'female';
    }

    /**
     * Checks if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin == true;
    }

    public function isAvailable($weekId) {
        return (bool) $this->availability->find($weekId)->pivot->attending;
    }
}
