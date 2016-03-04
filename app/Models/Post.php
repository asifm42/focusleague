<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Get the user that wrote this post.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'posted_by');
    }
}
