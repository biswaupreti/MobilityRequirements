<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaysOfInteractionVoting extends Model
{

    protected $table = 'ways_of_interaction_voting';

    protected $fillable = [
        'context_id',
        'user_id',
        'accompanying',
        'intermittent',
        'interaction'
    ];
}
