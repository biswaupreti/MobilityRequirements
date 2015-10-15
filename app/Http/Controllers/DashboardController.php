<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public $user = '';

    public function __construct()
    {
        $this->middleware('auth');
        if(Auth::user()){
            $this->user = Auth::user()->name;
        }
    }
    
    
    public function index()
    {
        $user = $this->user;
        return view('dashboard.index', compact('user'));
    }
}
