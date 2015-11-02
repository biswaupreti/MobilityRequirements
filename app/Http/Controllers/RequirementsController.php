<?php

namespace App\Http\Controllers;

use App\Requirements;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

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
        return view('requirements.create', compact('project_id'));
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
        Requirements::create($request->all());

        Session::flash('flash_message', 'Congratulations, New requirement added successfully!');

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
        $requirement = Requirements::find($id);
        $project_id = $requirement->project_id;
        return view('requirements.edit', compact('requirement', 'project_id'));
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
        $requirement->delete();

        Session::flash('flash_message', 'Requirement successfully deleted!');

        return redirect("projects/$project_id");
    }
}
