<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $table = 'transactions';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'transacted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cycle_id', 'user_id', 'week_id', 'type', 'description', 'payment_type', 'amount', 'created_by', 'date'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the cycle the transaction belongs to
     */
    public function cycle()
    {
        return $this->belongsTo('App\Models\Cycle');
    }

    /**
     * Get the user the transaction belongs to
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the week the transaction belongs to
     */
    public function week()
    {
        return $this->belongsTo('App\Models\Week');
    }

    /**
     * Scope a query to only include transactions of a given type.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the transaction date.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        $originalDate = $value;
        return date("m-d-Y", strtotime($originalDate));
    }

    /**
     * Set the transaction date.
     *
     * @param  string  $value
     * @return string
     */
    public function setDateAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['date'] = date("Y-m-d");
        } else {
            $this->attributes['date'] = date("Y-m-d", strtotime($value));
        }
    }
}
