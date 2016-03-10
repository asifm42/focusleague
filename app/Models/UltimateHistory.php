<?php

namespace App\Models;

use App\Traits\TrimScalarValues;
use Illuminate\Database\Eloquent\Model;

class UltimateHistory extends Model
{
    use TrimScalarValues;

    protected $table = 'ultimate_history';

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
        'club_affiliation', 'years_played', 'summary', 'fav_defensive_position', 'fav_offensive_position', 'def_or_off', 'best_skill', 'skill_to_improve', 'best_throw', 'throw_to_improve',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];


    /**
     * Get the user that this ultimate history belongs to
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
