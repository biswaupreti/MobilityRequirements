<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contextScenarioIdealWay extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'context_scenario_ideal_way';


    /**
     * Get context ideal way data in key:id => value:context_name pair
     *
     * @return array
     */
    public static function getContextIdealWayKeyValue()
    {
        $context_data = ContextScenarioIdealWay::select('id', 'context_name', 'full_name')->get()->toArray();
        $context_ideal_way = array();
        if($context_data){
            foreach($context_data as $item){
                $context_ideal_way[$item['id']] = ($item['context_name'] . ': ' . $item['full_name']);
            }
        }

        return $context_ideal_way;
    }
}
