<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContextRatings extends Model
{
    protected $fillable = [
        'context_id',
        'user_id',
        'rating'
    ];
}
