<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContextRemarksRelation extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'context_remarks_relation';

    protected $fillable = [
        'context_id',
        'user_id',
        'remarks'
    ];
}
