<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Week extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['starts_at', 'ends_at', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rained_out' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

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
     *
     * @return integer
     */
    public function week_index()
    {
        return $this->index;
    }

    /**
     * Get the index of the week within the cycle.
     *
     * @return integer
     */
    public function index()
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cycle()
    {
        return $this->belongsTo('App\Models\Cycle', 'cycle_id');
    }

    /**
     * Get the users who have signed up for the week.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function signups()
    {
        return $this->belongsToMany('App\Models\User', 'availability')->withPivot('id', 'attending')->whereNull('availability.deleted_at')->withTimestamps();
    }

    /**
     * Get the players (users) who are assigned to a team and are attending.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players()
    {
        $week = $this;
        // signups who are assigned to a team
        return $this->signups
            ->filter(function($signup) use ($week) {
                return $signup->isAvailable($week->id);
            })
            ->filter(function($signup) use ($week) {
                return $week->cycle->signupsOnATeam()->contains($signup->id);
            });
    }

    /**
     * Get the users who have signed up as a sub for the week.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subs()
    {
        return $this->belongsToMany('App\Models\User', 'subs')
                    ->withPivot('id', 'note', 'team_id')
                    ->whereNull('subs.deleted_at') // for soft deletes
                    ->withTimestamps();
    }

    /**
     * Get the users who have signed up as a sub for the week.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subsOnATeam()
    {
        return $this->belongsToMany('App\Models\User', 'subs')
                    ->withPivot('id', 'note', 'team_id')
                    ->whereNotNull('team_id')
                    ->whereNull('subs.deleted_at') // for soft deletes
                    ->withTimestamps();
    }

    public function games() {
        return $this->hasMany('App\Models\Game');
    }

    public function isRainedOut() {
        return $this->rained_out;
    }

    public function hasStatus() {
        return ! is_null($this->status);
    }

    // public function status() {
    //     return $this->status;
    // }

    public function updateStatus($status) {
        $this->status = $status;
        $this->save();
        return $this;
    }

    public function markAsRainedOut() {
        $this->rained_out = true;
        $this->save();
        return $this;
    }

    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }
}
