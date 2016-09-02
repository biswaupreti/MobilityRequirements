<?php

namespace App\Http\Controllers;

use App\ContextScenarioUserAppInteraction;
use App\ContextScenarioIdealWay;
use App\ContextSceneRelation;
use App\Projects;
use App\Scenarios;
use App\Requirements;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Psy\Context;

class RequirementsController extends BaseController
{
    private $rules = ['title' => 'required|min:5', 'description' => 'required', 'scenario_id' => 'required'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $scenario_id = Input::get('scenario');

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/scenarios/$scenario_id"
        );

        return view('requirements.create', compact('scenario_id', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $data = $request->all();
        $data['user_id'] = $this->user['id'];

        try{
            $new_requirement = Requirements::create($data);

            if($new_requirement->id){
                $context_ideal_ways = ContextScenarioIdealWay::get();
                if($context_ideal_ways){
                    foreach($context_ideal_ways as $row){
                        $context_new_data_arr = array(
                            'requirement_id' => $new_requirement->id,
                            'user_id' => $data['user_id'],
                            'context_id' => $row->id,
                            'accompanying' => $row->accompanying,
                            'intermittent' => $row->intermittent,
                            'interrupting' => $row->interrupting
                        );
                        ContextScenarioUserAppInteraction::insert($context_new_data_arr);
                    }
                }
            }
            Session::flash('flash_message', 'Congratulations, New requirement added successfully!');
        }
        catch(Exception $e){
            Session::flash('flash_message_error', 'Sorry, An error occurred while creating new requirement!');
        }

        return redirect("scenarios/$request->scenario_id");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requirement = Requirements::find($id);
        $scenario = Scenarios::find($requirement->scenario_id);
        $project = Projects::find($scenario->project_id);
        $context = ContextScenarioUserAppInteraction::leftJoin('users', 'users.id', '=', 'context_scenario_user_app_interaction.user_id')
                                                    ->leftJoin('context_scenario_ideal_way AS context', 'context.id', '=', 'context_scenario_user_app_interaction.context_id')
                                                    ->leftJoin('context_ratings as CR', 'CR.context_id', '=', 'context_scenario_user_app_interaction.id')
                                                    ->leftJoin('context_ratings as CR1', function($join)
                                                    {
                                                        $join->on('CR1.context_id', '=', 'context_scenario_user_app_interaction.id');
                                                        $join->where('CR1.user_id','=', $this->user['id']);
                                                    })
                                                    ->leftJoin('ways_of_interaction_voting as WOIV', function($join)
                                                    {
                                                        $join->on('WOIV.context_id', '=', 'context_scenario_user_app_interaction.id');
                                                        $join->where('WOIV.user_id','=', $this->user['id']);
                                                    })
                                                    ->select('context_scenario_user_app_interaction.*',
                                                                'users.name AS user_name',
                                                                'context.context_name',
                                                                'context.full_name',
                                                                'CR1.rating',
                                                                DB::raw('avg(CR.rating) AS avg_rating, count(CR.id) AS rating_count'),
                                                                'WOIV.accompanying', 'WOIV.intermittent', 'WOIV.interrupting'
                                                            )
                                                    ->where('requirement_id', $id)
                                                    ->groupBy('context_scenario_user_app_interaction.id')
                                                    ->orderBy('context_id', 'asc')->get();

        $context_arr = $context->toArray();
        if($context_arr) {
            foreach($context_arr as &$c) {
                $cid = $c['id'];
                $context_scene = ContextSceneRelation::select('context_scene_relation.user_id AS context_scene_user', 'context_scene_relation.scene', 'users.name AS user_name')
                                                    ->leftJoin('users', 'users.id', '=', 'context_scene_relation.user_id')
                                                    ->where('context_id', $cid)->get()->toArray();
                $c['scenes'] = $context_scene;
                $c = (object) $c;
            }
        }

        $context_arr = (object) $context_arr;

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/scenarios/$requirement->scenario_id"
        );
        
        return view('requirements.details', compact('requirement', 'context_arr', 'project', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requirement = Requirements::find($id);
        $scenario_id = $requirement->scenario_id;

        if($requirement->user_id != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect("scenarios/$scenario_id");
        }

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/scenarios/$scenario_id"
        );

        return view('requirements.edit', compact('requirement', 'scenario_id', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $requirement = Requirements::find($id);
        $updateData = $request->all();

        if(!isset($updateData["accompanying"])){
            $updateData["accompanying"] = '0';
        }
        if(!isset($updateData["intermittent"])){
            $updateData["intermittent"] = '0';
        }
        if(!isset($updateData["interrupting"])){
            $updateData["interrupting"] = '0';
        }

        $requirement->update($updateData);

        Session::flash('flash_message', 'Congratulations, Requirement updated successfully!');

        return redirect("scenarios/$request->scenario_id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requirement = Requirements::findOrFail($id);
        $project_id = $requirement->project_id;

        if($requirement->user_id != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect("projects/$project_id");
        }

        $requirement->delete();

        Session::flash('flash_message', 'Requirement successfully deleted!');

        return redirect("projects/$project_id");
    }


    public function review(Request $request)
    {
        $requirement_id = $request->segment(2);
        $requirement = Requirements::find($requirement_id);
        $project = Projects::find($requirement->project_id);
        DB::enableQueryLog();
        $context = ContextScenarioUserAppInteraction::leftJoin('users', 'users.id', '=', 'context_scenario_user_app_interaction.user_id')
            ->leftJoin('context_scenario_ideal_way AS context', 'context.id', '=', 'context_scenario_user_app_interaction.context_id')
            ->leftJoin('context_ratings as CR', 'CR.context_id', '=', 'context_scenario_user_app_interaction.id')
            ->select('context_scenario_user_app_interaction.*',
                'users.name AS user_name',
                'context.context_name',
                'context.full_name',
                DB::raw('avg(CR.rating) AS avg_rating,
                        count(CR.id) AS rating_count')
            )
            ->where('requirement_id', $requirement_id)
            ->groupBy('context_scenario_user_app_interaction.id')->get()->toArray();
        $context_voting = ContextScenarioUserAppInteraction::leftJoin('ways_of_interaction_voting as WOIV', 'WOIV.context_id', '=', 'context_scenario_user_app_interaction.id')
            ->select('context_scenario_user_app_interaction.id',
                DB::raw('sum(WOIV.accompanying) as accompanying_count,
                        sum(WOIV.intermittent) as intermittent_count,
                        sum(WOIV.interrupting) as interrupting_count')
            )
            ->where('requirement_id', $requirement_id)
            ->groupBy('context_scenario_user_app_interaction.id')->get()->toArray();
        foreach($context as &$value1) {
            foreach ($context_voting as $value2) {
                if($value1['id'] == $value2['id']) {
                    $value1 = array_merge($value1, $value2);
                }
            }
        }
        usort($context, function($i, $j){
            $a = $i['avg_rating'];
            $b = $j['avg_rating'];
            if ($a == $b) return 0;
            elseif ($a > $b) return 1;
            else return -1;
        });
        $context = array_reverse($context);
        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/projects/$requirement->project_id"
        );
        return view('requirements.review', compact('requirement', 'context', 'project', 'breadcrumbs'));
    }

   /* public function review(Request $request)
    {
        $requirement_id = $request->segment(2);
        $requirement = Requirements::find($requirement_id);
        $project = Projects::find($requirement->project_id);
        DB::enableQueryLog();

        $context = ContextScenarioUserAppInteraction::leftJoin('users', 'users.id', '=', 'context_scenario_user_app_interaction.user_id')
            ->leftJoin('context_scenario_ideal_way AS context', 'context.id', '=', 'context_scenario_user_app_interaction.context_id')
            ->leftJoin('context_ratings as CR', 'CR.context_id', '=', 'context_scenario_user_app_interaction.id')
            ->select('context_scenario_user_app_interaction.id',
                'context_scenario_user_app_interaction.requirement_id',
                'context_scenario_user_app_interaction.user_id',
                'context_scenario_user_app_interaction.context_id',
                'context_scenario_user_app_interaction.scenario',
                'context_scenario_user_app_interaction.remarks',
                'users.name AS user_name',
                'context.context_name',
                'context.accompanying',
                'context.intermittent',
                'context.interrupting',
                DB::raw('avg(CR.rating) AS avg_rating,
                        count(CR.id) AS rating_count')
            )
            ->where('requirement_id', $requirement_id)
            ->groupBy('context_scenario_user_app_interaction.id')
            ->orderBy('avg_rating', 'DESC')->get();

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/projects/$requirement->project_id"
        );

        return view('requirements.review', compact('requirement', 'context', 'project', 'breadcrumbs'));
    }*/

}
