<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContextScenarioUserAppInteraction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'context_scenario_user_app_interaction';

    protected $fillable = [
        'requirement_id',
        'user_id',
        'context_id',
        'scenario'
    ];
}
