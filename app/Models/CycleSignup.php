<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;

class CycleSignup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $table = 'cycle_user';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cycle_id', 'user_id', 'div_pref_first', 'div_pref_seconde', 'note', 'team_id', 'captain', 'will_captain'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the cycle the sign up belongs to
     */
    public function cycle()
    {
        return $this->belongsTo('App\Models\Cycle');
    }

    /**
     * Get the user the sign up belongs to
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the team the signup belongs to
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function isRigid(String $division = NULL) {
        if (is_null($division)) {
            if (empty($this->div_pref_second) || ($this->div_pref_first === $this->div_pref_second)) {
                return $this->div_pref_first;
            } else {
                return false;
            }
        } else {
            if ((empty($this->div_pref_second)
                && (strtolower($this->div_pref_first) === strtolower($division)))) {
                return true;
            } elseif ((strtolower($this->div_pref_second) === strtolower($division))
                && (strtolower($this->div_pref_first) === strtolower($division))) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isFlexible(String $division = NULL) {
        if (is_null($division)) {
            if ((!empty($this->div_pref_second)) && ($this->div_pref_first !== $this->div_pref_second)) {
                return $this->div_pref_first;
            } else {
                return false;
            }
        } else {
            if ((!empty($this->div_pref_second)
                && (strtolower($this->div_pref_first) !== strtolower($this->div_pref_second))
                && (strtolower($this->div_pref_first) === strtolower($division)))) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function cost()
    {
        $weeks = $this->user->availability()->where('cycle_id',$this->cycle->id)->get();

        $attendingDates = collect();

        foreach($weeks as $week){
            if ($week->pivot->attending) {
                $attendingDates->push($week->starts_at->toFormattedDateString());
            }
        }

        if ($attendingDates->count() === 4){
            return config('focus_cost.cycle.four_weeks');
        } elseif ($attendingDates->count() === 3){
            return config('focus_cost.cycle.three_weeks');
        } elseif ($attendingDates->count() === 2) {
            return config('focus_cost.cycle.two_weeks');
        } elseif ($attendingDates->count() === 1) {
            return config('focus_cost.cycle.sub');
        } else {
            return config('focus_cost.cycle.two_weeks');
        }
    }
}
