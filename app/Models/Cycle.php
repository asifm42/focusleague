<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Cycle extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['signup_opens_at', 'signup_closes_at', 'starts_at', 'ends_at', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_by', 'signup_opens_at', 'signup_closes_at', 'starts_at', 'ends_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the cycle weeks
     */
    public function weeks()
    {
        return $this->hasMany('App\Models\Week', 'cycle_id')->orderBy('starts_at');
    }

    /**
     * Get the users who have signed up for the cycle.
     */
    public function signups()
    {
        return $this->belongsToMany('App\Models\User')
                    ->withPivot('id', 'div_pref_first', 'div_pref_second', 'note', 'team_id', 'captain', 'will_captain')
                    ->whereNull('cycle_user.deleted_at') // for soft deletes
                    ->withTimestamps();

    }

    public function status()
    {
        $now = Carbon::now();

        if ($now->lt($this->signup_opens_at)){
            return 'SIGNUP_OPENS_LATER';
        } elseif ($now->gt($this->signup_opens_at) && $now->lt($this->signup_closes_at)) {
            return 'SIGNUP_OPEN';
        } elseif ($now->gt($this->signup_closes_at) && $now->lt($this->starts_at)) {
            return 'SIGNUP_CLOSED';
        } elseif ($now->gt($this->starts_at) && $now->lt($this->ends_at)) {
            return 'IN_PROGRESS';
        } elseif ($now->gt($this->ends_at)) {
            return 'COMPLETED';
        }
    }

    /**
     * Scope a query to the current cycle.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        $now = Carbon::now();
        return $query->where('signup_opens_at', '<', $now)
                    ->where('ends_at', '>', $now);
    }

    /**
     * Get the current cycle.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function current_cycle()
    {
        $now = Carbon::now();
        return Cycle::where('signup_opens_at', '<', $now)
                    ->where('ends_at', '>', $now)
                    ->first();
    }

    /**
     * Scope a query to the current cycle.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function next_cycle()
    {

        $now = Carbon::now();
        return Cycle::where('signup_opens_at', '>', $now)
                    ->orderBy('signup_opens_at', 'asc')->first();
    }

}
