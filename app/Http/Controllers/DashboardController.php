<?php

namespace App\Http\Controllers;

use App\Projects;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{

    public function index()
    {

        $user_id = $this->user->id;
        $ownership = Projects::where('project_owner', $user_id)
                            ->where('status', '1')->get()->toArray();

        $membership = DB::select("SELECT * FROM projects WHERE find_in_set($user_id, project_members) <> 0 AND status = 1");

        return view('dashboard.index', compact('ownership', 'membership'));
    }
}
