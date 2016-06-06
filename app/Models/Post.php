<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * Get the user that wrote this post.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'posted_by');
    }
}
