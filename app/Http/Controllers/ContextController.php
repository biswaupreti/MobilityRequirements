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

class ContextController extends BaseController
{

    private $rules = ['scenario' => 'required', 'user_id' => 'required', 'requirement_id' => 'required'];

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
        $requirement_id = Input::get('requirement');
        $project = Requirements::select('project_id')->where('id', $requirement_id)->first();

        $context_ideal_way = ContextScenarioIdealWay::getContextIdealWayKeyValue();

        $breadcrumbs = array(
            'Projects' => "/projects",
            'All Requirements' => "/projects/$project->project_id",
            'All Context' => "requirements/$requirement_id"
        );

        return view('context.create', compact('requirement_id', 'context_ideal_way', 'breadcrumbs'));
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
        ContextScenarioUserAppInteraction::create($request->all());

        Session::flash('flash_message', 'Congratulations, New context added successfully!');

        return redirect("requirements/$request->requirement_id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $context = ContextScenarioUserAppInteraction::find($id);
        $requirement_id = $context->requirement_id;

        if($context->user_id != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect("requirements/$requirement_id");
        }

        $project = Requirements::select('project_id')->where('id', $requirement_id)->first();
        $context_ideal_way = ContextScenarioIdealWay::getContextIdealWayKeyValue();

        $breadcrumbs = array(
            'Projects' => "/projects",
            'All Requirements' => "/projects/$project->project_id",
            'All Context' => "requirements/$requirement_id"
        );

        return view('context.edit', compact('context', 'requirement_id', 'context_ideal_way', 'breadcrumbs'));
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

        $context = ContextScenarioUserAppInteraction::find($id);
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

        $context->update($updateData);

        Session::flash('flash_message', 'Congratulations, Data updated successfully!');
        return redirect("requirements/$request->requirement_id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $context = ContextScenarioUserAppInteraction::findOrFail($id);
        $requirement_id = $context->requirement_id;

        if($context->user_id != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect("requirements/$requirement_id");
        }

        $context->delete();

        Session::flash('flash_message', 'Data successfully deleted!');

        return redirect("requirements/$requirement_id");
    }


}
