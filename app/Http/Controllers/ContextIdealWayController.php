<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ContextScenarioIdealWay;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContextIdealWayController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $context = ContextScenarioIdealWay::get();

        $breadcrumbs = array();
        return view('context.contextIdealWay', compact('context', 'breadcrumbs'));
    }
}
