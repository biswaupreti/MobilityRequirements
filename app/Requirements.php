<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirements extends Model
{
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id'
    ];
}
