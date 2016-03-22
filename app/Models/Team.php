<?php

namespace App\Models;

use App\Traits\TrimScalarValues;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use TrimScalarValues, SoftDeletes;
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
        'name', 'division', 'cycle_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the team's cycle
     */
    public function cycle()
    {
        return $this->belongsTo('App\Models\Cycle', 'cycle_id');
    }

    /**
     * Get the team's players
     */
    public function players()
    {
        return $this->hasMany('App\Models\CycleSignup');
    }

    /**
     * Get the team's captains
     */
    public function captains()
    {
        return $this->hasMany('App\Models\CycleSignup')->where('captain', true);
    }

    /**
     * Get the team's name with division in parenthesis
     */
    public function nameAndDivision()
    {
        return ucwords($this->name) . ' (' . ucwords($this->division) . ')';
    }
}