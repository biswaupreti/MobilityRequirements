<?php

namespace App\Http\Controllers;

use App\Scenarios;
use App\Projects;
use App\Requirements;
use App\ContextScenarioIdealWay;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Psy\Context;

class ScenariosController extends BaseController
{
  private $rules = ['scene' => 'required'];

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

    $context_ideal_way = ContextScenarioIdealWay::getContextIdealWayKeyValue();

    $breadcrumbs = array(
      'Projects' => '/projects',
      'Scenarios' => "/projects/$project_id"
    );

    return view('scenarios.create', compact('project_id', 'context_ideal_way', 'breadcrumbs'));
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
      Scenarios::create($data);
      Session::flash('flash_message', 'Congratulations, New scenario added successfully!');
    }
    catch(Exception $e){
      Session::flash('flash_message_error', 'Sorry, An error occurred while creating new scenario!');
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
    $scenario = Scenarios::select('scenarios.*', 'context_scenario_ideal_way.context_name', 'context_scenario_ideal_way.full_name')
      ->leftJoin('context_scenario_ideal_way', 'context_scenario_ideal_way.id', '=', 'scenarios.context_id')
      ->where('scenarios.id', $id)->first();

    $project = Projects::find($scenario->project_id);

    $requirements = Requirements::leftJoin('users', 'users.id', '=', 'requirements.user_id')
      ->select('requirements.*', 'users.name as created_by')
      ->where('scenario_id', $id)->latest()->get();

    $breadcrumbs = array(
      'Projects' => '/projects',
      'Scenarios' => "/projects/$scenario->project_id"
    );

    return view('scenarios.details', compact('scenario', 'project', 'requirements', 'breadcrumbs'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $scenario = Scenarios::find($id);
    $project_id = $scenario->project_id;

    if($scenario->user_id != $this->user['id']){
      Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
      return redirect("projects/$project_id");
    }

    $context_ideal_way = ContextScenarioIdealWay::getContextIdealWayKeyValue();

    $breadcrumbs = array(
      'Projects' => '/projects',
      'Scenarios' => "/projects/$project_id"
    );

    return view('scenarios.edit', compact('scenario', 'project_id', 'context_ideal_way', 'breadcrumbs'));
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

    $scenario = Scenarios::find($id);
    $updateData = $request->all();

    $scenario->update($updateData);

    Session::flash('flash_message', 'Congratulations, Scenario updated successfully!');

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
    $scenario = Scenarios::findOrFail($id);
    $project_id = $scenario->project_id;

    if($scenario->user_id != $this->user['id']){
      Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
      return redirect("projects/$project_id");
    }

    $scenario->delete();

    Session::flash('flash_message', 'Scenario successfully deleted!');

    return redirect("projects/$project_id");
  }
}
