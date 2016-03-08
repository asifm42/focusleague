<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
        'name', 'nickname', 'gender', 'birthday', 'cell_number', 'dominant_hand', 'height', 'division_preference_first', 'division_preference_second', 'image', 'admin', 'season_pass_ends_on', 'ip_address', 'last_login',
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
        return $this->belongsToMany('App\Models\Cycle');
    }

    /**
     * Get the weeks the user has signed up for
     */
    public function availability()
    {
        return $this->belongsToMany('App\Models\Week', 'availability')->withPivot('attending')->withTimestamps();
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
}
