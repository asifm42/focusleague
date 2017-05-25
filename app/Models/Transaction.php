<?php

namespace App\Models;

use App\Models\User;
use App\Models\Week;
use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * Get the user's birthday.
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
     * Set the user's birthday.
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

    public static function rainoutCredit(User $user, Week $week)
    {
        $data = [
            'cycle_id'      => $week->cycle->id,
            'week_id'       => $week->id,
            'type'          => 'credit',
            'created_by'    => auth()->id() || 1,
            'date'          => $week->starts_at->format('Y-m-d'),
            'description'   => 'Rainout credit',
            'amount'        => config('focus.cost.rainout_credit')
        ];

        // create the transaction
        $transaction = new Self($data);

        // if user is a captain, then factor in the 25% discount they received.
        if ($user->isCaptain($week->cycle)) {
            $transaction->amount = round ( ($transaction->amount * 0.75), 2, PHP_ROUND_HALF_DOWN );
            $transaction->description = 'Rainout captain credit';
        }

        // if user is a sub then up the credit to 10 and update the description
        if ($week->subsOnATeam->contains($user)) {
            $transaction->amount = config('focus.cost.cycle.sub');
            $transaction->description = 'Rainout sub credit';
        }

        // save the signup's transaction
        $user->transactions()->save($transaction);

        return $transaction->fresh();
    }
}
