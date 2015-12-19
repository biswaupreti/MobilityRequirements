<?php

namespace App\Http\Controllers;

use App\ContextScenarioUserAppInteraction;
use App\ContextScenarioIdealWay;
use App\Requirements;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Psy\Context;

class RequirementsController extends BaseController
{
    private $rules = ['title' => 'required|min:5', 'description' => 'required', 'project_id' => 'required'];

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
        $project_id = Input::get('project');

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/projects/$project_id"
        );

        return view('requirements.create', compact('project_id', 'breadcrumbs'));
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

        return redirect("projects/$request->project_id");
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
        $context = ContextScenarioUserAppInteraction::leftJoin('users', 'users.id', '=', 'context_scenario_user_app_interaction.user_id')
                                                    ->leftJoin('context_scenario_ideal_way AS context', 'context.id', '=', 'context_scenario_user_app_interaction.context_id')
                                                    ->select('context_scenario_user_app_interaction.*', 'users.name AS user_name', 'context.context_name')
                                                    ->where('requirement_id', $id)
                                                    ->orderBy('context_id', 'asc')->get();

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/projects/$requirement->project_id"
        );

        return view('requirements.details', compact('requirement', 'context', 'breadcrumbs'));
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
        $project_id = $requirement->project_id;

        if($requirement->user_id != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect("projects/$project_id");
        }

        $breadcrumbs = array(
            'Projects' => '/projects',
            'All Requirements' => "/projects/$project_id"
        );

        return view('requirements.edit', compact('requirement', 'project_id', 'breadcrumbs'));
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

        $requirement->update($request->all());

        Session::flash('flash_message', 'Congratulations, Requirement updated successfully!');

        return redirect("projects/$request->project_id");
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
}
