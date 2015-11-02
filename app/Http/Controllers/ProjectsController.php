<?php

namespace App\Http\Controllers;

use App\Projects;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Requirements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends BaseController
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->user;

        $projects = Projects::latest()->get();
        
        return view('projects.index', compact('projects', 'user'));
    }


    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $project = Projects::find($id);
        $requirements = Requirements::where('project_id', $id)->latest()->get();

        return view('projects.details', compact('project', 'requirements'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }


    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|min:5', 'project_owner' => 'required']);

        Projects::create($request->all());

        Session::flash('flash_message', 'Congratulations, New project added successfully!');

        return redirect('projects');
    }


    public function edit($id)
    {
        $project = Projects::find($id);

        return view('projects.edit', compact('project'));
    }



    public function update($id, Request $request)
    {
        $this->validate($request, ['title' => 'required|min:5', 'project_owner' => 'required']);

        $project = Projects::find($id);

        $project->update($request->all());

        Session::flash('flash_message', 'Congratulations, Project updated successfully!');

        return redirect('projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Projects::findOrFail($id);
        $project->delete();

        Session::flash('flash_message', 'Project successfully deleted!');

        return redirect("projects");
    }
}
