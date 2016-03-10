<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['starts_at', 'ends_at', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cycle_id', 'starts_at', 'ends_at', 'rained_out',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the index of the week within the cycle.
     */
    public function week_index()
    {
        $cycle_weeks = $this->cycle->weeks;
        $num=0;
        foreach ($cycle_weeks as $week) {
            $num++;
            if ($week->id === $this->id) {
                return $num;
            }
        }
    }

    /**
     * Get the cycle the week belongs to
     */
    public function cycle()
    {
        return $this->belongsTo('App\Models\Cycle', 'cycle_id');
    }

    /**
     * Get the users who have signed up for the cycle.
     */
    public function signups()
    {
        return $this->belongsToMany('App\Models\User', 'availability')->withPivot('id', 'attending')->withTimestamps();
    }

    /**
     * Get the users who have signed up as a sub for the week.
     */
    public function subs()
    {
        return $this->belongsToMany('App\Models\User', 'subs')
                    ->withPivot('id', 'note', 'team_id')
                    ->whereNull('subs.deleted_at') // for soft deletes
                    ->withTimestamps();
    }
}
