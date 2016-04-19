<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;

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
            'week_id', 'starts_at', 'ends_at', 'rained_out','field', 'division', 'format', 'created_by',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the week that the game will be on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function week() {
        return $this->belongsTo('App\Models\Week');
    }

    /**
     * Get the the teams that are playing in the game.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams() {
        return $this->belongsToMany('App\Models\Team')
        ->withPivot('id','points_scored');
    }
}
