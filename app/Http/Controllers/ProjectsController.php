<?php

namespace App\Http\Controllers;

use App\Projects;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(Auth::user()){
            $user = Auth::user()->name;
        }

        $projects = Projects::latest()->get();
        
        return view('projects.index', compact('projects', 'user'));
    }


    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function details($id)
    {
        $project = Projects::find($id);

        return view('projects.details', compact('project'));
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

        return redirect('projects');
    }
}
