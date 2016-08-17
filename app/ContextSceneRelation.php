<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContextSceneRelation extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'context_scene_relation';

    protected $fillable = [
        'context_id',
        'user_id',
        'scene'
    ];
}
