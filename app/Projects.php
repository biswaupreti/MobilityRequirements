<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'project_owner'
    ];
    
}
