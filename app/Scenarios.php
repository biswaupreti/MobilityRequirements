<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenarios extends Model
{
    protected $fillable = [
        'project_id',
        'scene',
        'context_id',
        'user_group',
        'action_info',
        'user_id',
    ];
}
