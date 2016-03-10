<?php

namespace App\Models;

use App\Traits\TrimScalarValues;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class CycleSignup extends Model
{
    use TrimScalarValues;

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
}
