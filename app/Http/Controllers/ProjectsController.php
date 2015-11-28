<?php

namespace App\Http\Controllers;

use App\Projects;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Requirements;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends BaseController
{

    private $rules = ['title' => 'required|min:5', 'project_owner' => 'required', 'project_members' => 'required', 'status' => 'required'];

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs = array(
            'Projects' => '/projects'
        );
        View::share('breadcrumbs', $this->breadcrumbs);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->user;

        $projects = Projects::leftJoin('users', 'users.id', '=', 'projects.project_owner')
            ->select('projects.*', 'users.name')
            ->orderBy('projects.id', 'desc')
            ->get();

        return view('projects.index', compact('projects', 'user'));
    }


    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $project = Projects::leftJoin('users', 'users.id', '=', 'projects.project_owner')
            ->select('projects.*', 'users.name as owner')
            ->where('projects.id', $id)
            ->first();

        $requirements = Requirements::leftJoin('users', 'users.id', '=', 'requirements.user_id')
                                    ->select('requirements.*', 'users.name as created_by')
                                    ->where('project_id', $id)->latest()->get();

        return view('projects.details', compact('project', 'requirements'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $owners = User::getUsersByRoles([1,2]);
        $members = User::getUsersByRoles([2,3]);

        return view('projects.create', compact('owners', 'members'));
    }


    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $data = $request->all();
        $data['project_members'] = implode(',', $data['project_members']);

        Projects::create($data);

        Session::flash('flash_message', 'Congratulations, New project added successfully!');

        return redirect('projects');
    }


    public function edit($id)
    {
        $project = Projects::find($id);

        if($project->project_owner != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect('projects');
        }

        $selected_members = explode(',', $project->project_members);

        $owners = User::getUsersByRoles([1,2]);
        $members = User::getUsersByRoles([2,3]);

        return view('projects.edit', compact('project', 'owners', 'members', 'selected_members'));
    }



    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);

        $project = Projects::find($id);

        $data = $request->all();
        $data['project_members'] = implode(',', $data['project_members']);

        $project->update($data);

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

        if($project->project_owner != $this->user['id']){
            Session::flash('flash_message_warning', 'Sorry, you do not have enough privilege to make this change!');
            return redirect('projects');
        }

        $project->delete();

        Session::flash('flash_message', 'Project successfully deleted!');

        return redirect("projects");
    }



}
