<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'scenario',
        'project_owner',
        'project_members',
        'status'
    ];
    
}
